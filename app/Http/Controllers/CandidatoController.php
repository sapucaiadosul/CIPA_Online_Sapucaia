<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidatos;
use App\Eleicoes;
use App\Http\Requests\CandidatoRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CandidatoController extends Controller
{
    public function index(Request $request)
    {
        $eleicaoId = $request->input('eleicao_id');

        if ($eleicaoId) {
            $candidatos = Candidatos::where('eleicoes_id', $eleicaoId)->get();
        } else {
            $ultimaEleicao = Eleicoes::orderBy('id', 'desc')->first();
            $candidatos = Candidatos::where('eleicoes_id', $ultimaEleicao->id);
            $eleicaoId = $ultimaEleicao->id;
        }

        $eleicoes = Eleicoes::all();

        return view('candidato.login_candidato', compact('candidatos', 'eleicoes', 'eleicaoId'))->with('success', 'Por favor, faça login para acessar o sistema.');
    }

    public function login_candidato(Request $request)
    {

        try {
            DB::connection('banco_rh');
        } catch (\Throwable $e) {
            return redirect()->back()->with('NaoConectouBanco', '404');
        }

        $matriculaCandidato = $request->input('matricula');

        $eleicao_id = DB::table('eleicoes')->max('id');

        $eleicao = DB::table('eleicoes')
            ->where('id', $eleicao_id)
            ->where('dt_inscricao_de', '<=', Carbon::now())
            ->where('dt_inscricao_ate', '>=', Carbon::now())
            ->first();

        if (!$eleicao) {
            return redirect()->back()->with('SemData', '404');
        }

        $candidatoExiste = candidatos::where('matricula', $matriculaCandidato)->where('eleicoes_id', $eleicao->id)->first();
        if ($candidatoExiste) {
            return redirect()->route('Candidato_Index')->with('JaTemCadastro', '404');
        }

        $matricula = $request->input('matricula');
        $datanasc = $request->input('datanasc');
        $formato_data = 'DD/MM/YYYY';
        $datanasc = Carbon::createFromFormat('Y-m-d', $datanasc)->format('d-m-Y');

        $import = DB::connection('banco_rh')->select(
            'select serv.CD_MATRICULA MATRICULA, p.NM_COMPLETO NOME, p.NR_CPF CPF, p.DT_NASCIMENTO, serv.DT_ADMISSAO, vinc.CD_VINCULO, vinc.VINCULO,cargo.DS_CARGO, 
        LOTACAO.DEPARTAMENTO, LOTACAO.SECRETARIA, 
        (Case when PORTARIA_ESTAGIO.ID_DOCS is not null then ? else ? end) POSSUI_PORTARIA, trunc(CURRENT_DATE - serv.DT_ADMISSAO) DIAS_SERVICO
        from RHSLEO.WIZ_RHF_SERVIDORES serv, RHSLEO.WIZ_COR_PESSOAS p, RHSLEO.WIV_RHF_SERVIDORES_VINCULO vinc, RHSLEO.WIZ_RHF_CARGOS cargo, 
        RHSLEO.WIZ_RHF_SERVIDOR_CARGOS serv_carg,
         (select serv_custos.ID_SERV, custos.nome as DEPARTAMENTO, serv_custos.DT_INIC, serv_custos.DT_FINAL, sec.nome as SECRETARIA
        from RHSLEO.WIZ_RHF_SERVIDOR_CCUSTOS serv_custos, RHSLEO.WIZ_COR_CENTRO_CUSTOS custos, RHSLEO.WIZ_COR_CENTRO_CUSTOS sec
        where Serv_Custos.Ccst_Sequencia = Custos.Ccst_Sequencia
        AND custos.CCST_SEQUENCIA = serv_custos.CCST_SEQUENCIA
        and sec.ID_FILL (+)= custos.ID_FILL 
        and sec.CD_ESTRUT (+)= SUBSTR(custos.CD_ESTRUT,0,10) 
        and serv_custos.IN_LOTACAO = ?
         ) LOTACAO,
        (select serv_docs.ID_SERV, docs.ID_DOCS, docs.ID_ASSU, docs.DS_EMENTA from RHSLEO.WIZ_RHF_SERVIDOR_DOCUMENTOS serv_docs, RHSLEO.WIZ_RHF_DOCUMENTOS docs
        where serv_docs.ID_DOCS = docs.ID_DOCS and docs.ID_ASSU = 87 and docs.ST_DOC = ?) PORTARIA_ESTAGIO
        where serv.ID_PESS = p.ID_PESS
        and serv.ST_SERVIDOR = 1
        and vinc.ID_SERV = serv.ID_SERV
        and serv_carg.ID_SERV = serv.ID_SERV 
        and cargo.ID_CARG = serv_carg.ID_CARG 
        and serv_carg.DT_FINAL is null
        and LOTACAO.ID_SERV = serv.ID_SERV 
        and LOTACAO.DT_FINAL is null
        and serv.CD_MATRICULA = ?
        and p.DT_NASCIMENTO = to_date(?,?)
        and PORTARIA_ESTAGIO.ID_SERV (+)= serv.ID_SERV',
            ['S', 'N', 'E', 'A',  $matricula, $datanasc, $formato_data]
        );

        $candidatoAutenticado = new candidatos;

        if ($import) {
            $candidatoAutenticado->matricula = $import[0]->matricula;
            $candidatoAutenticado->cpf = $import[0]->cpf;
            $candidatoAutenticado->nome = $import[0]->nome;
            $dt_nascimento = \Carbon\Carbon::parse($import[0]->dt_nascimento)->format('Y-m-d');
            $candidatoAutenticado->dt_nascimento = $dt_nascimento;
            $candidatoAutenticado->cd_vinculo = $import[0]->cd_vinculo;
            $candidatoAutenticado->vinculo = $import[0]->vinculo;
            $candidatoAutenticado->ds_cargo = $import[0]->ds_cargo;
            $candidatoAutenticado->departamento = $import[0]->departamento;
            $candidatoAutenticado->secretaria = $import[0]->secretaria;
            $candidatoAutenticado->possui_portaria = $import[0]->possui_portaria;
            $candidatoAutenticado->dias_servico = $import[0]->dias_servico;
        } else {
            return redirect()->back()->with('NaoAchou', '404');
        }

        if ($candidatoAutenticado->cd_vinculo != '1' && $candidatoAutenticado->cd_vinculo != '2') {
            return redirect()->back()->with('VinculoNaoPermitido', '404');
        } else if (
            $candidatoAutenticado->cd_vinculo  == '2' &&
            $candidatoAutenticado->possui_portaria == 'N' &&
            $candidatoAutenticado->dias_servico <= 1095
        ) {
            return redirect()->back()->with('SemEstabilidade', '404');
        }

        if ($eleicao) {
            return view('candidato.novo_candidato', ['eleicao' =>  $eleicao, 'candidatoAutenticado' => $candidatoAutenticado]);
        } else {
            return redirect()->back()->with('SemData', '404');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('CIPA_Online.Welcome');
    }

    public function create($candidato)
    {
        return view('candidato.novo_candidato', compact('candidato', 'periodo_inscricao', 'resulta'));
    }

    public function store(CandidatoRequest $request)
    {

        $data = $request->validated();

        $eleicao = DB::table('eleicoes')
            ->where('dt_inscricao_de', '<=', Carbon::now())
            ->where('dt_inscricao_ate', '>=', Carbon::now())
            ->first();

        if (!$eleicao) {
            return redirect()->route('Candidato_Index')->with('SemData', '404');
        }


        $candidatoExiste = candidatos::where('matricula', $request->input('matricula'))->where('eleicoes_id', $eleicao->id)->first();
        if ($candidatoExiste) {
            return redirect()->route('Candidato_Index')->with('JaTemCadastro', '404');
        }

        $cadastro = new candidatos();
        $param = eleicoes::find($request->input('eleicoes_id'));
        $cadastro->Eleicoes()->associate($param);

        $cpfSanitizado = $request->input('cpf');
        if ($request->input('cpf')) {
            $cpfSanitizado = str_replace(array('.', '-'), '', $request->input('cpf'));
            $request->merge([
                'cpf' => $cpfSanitizado,
            ]);
        };
        $cadastro->matricula = $request->input('matricula');
        $cadastro->nome = $request->input('nome');
        $cadastro->apelido = $data['apelido'];
        $cadastro->email = $data['email'];
        $cadastro->telefone = $data['telefone'];
        $cadastro->dt_nascimento = $request->input('dt_nascimento');
        $cadastro->cpf =  $request->input('cpf');
        $cadastro->lotacao =  $request->input('lotacao');
        $cadastro->cargo_funcao =  $request->input('cargo_funcao');
        $cadastro->indicado = $request->input('indicado');

        $cadastro->vinculo = $request->input('cd_vinculo');
        $cadastro->estabilidade = $request->input('estabilidade');

        $foto_string_original = $request->input('foto_cortada');
        $cadastro->historico = $request->input('historico');
        $cadastro->status = 0;  // Pendente
        $cadastro->save();

        $foto_base64_string = explode(",", $foto_string_original);

        if ($foto_base64_string) {
            $arquivoComCaminho = 'arquivos/fotos/foto_' .  $cadastro->id . '.png';
            $cadastro->foto = $arquivoComCaminho;
            Storage::put($cadastro->foto, base64_decode($foto_base64_string[1]));
            $cadastro->update();
        }
        return view('candidato.inscricao_concluida', ['candidato_id' => $cadastro->id]);
    }

    public function edit($id)
    {
        $candidato = candidatos::find($id);
        $eleicoes = eleicoes::all();
        if ($candidato) {
            return view('candidato.edit_candidato', compact('candidato', 'eleicoes'));
        }
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $candidato = candidatos::find($request->candidato_id);

        $cpfSanitizado = Session::get('cpf');
        if ($request->input('cpf')) {
            $cpfSanitizado = str_replace(array('.', '-'), '', $request->input('cpf'));
            $request->merge([
                'cpf' => $cpfSanitizado,
            ]);
        };

        if (!$candidato) {
            return redirect()->back();
        } else {
            $candidato->update([
                'eleicoes_id' => 1,
                'matricula' => $request->matricula,
                'nome' => $request->nome,
                'apelido' => $request->apelido,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'dt_nascimento' => $request->dt_nascimento,
                'cpf' => $cpfSanitizado,
                'lotacao' => $request->lotacao,
                'cargo_funcao' => $request->cargo_funcao,
                'indicado' => $request->indicado,
                'vinculo' => $request->vinculo,
                'estabilidade' => $request->estabilidade,
                'historico' => $request->historico,
                'status' => $request->status,
            ]);

            if ($request->hasFile('foto')) {
                if ($candidato->foto && Storage::exists($candidato->foto)) {
                    Storage::delete($candidato->foto);
                }
                $candidato->foto = $request->foto->store('arquivos/fotos');
                $candidato->update();
            }
            return redirect()->route('Candidato_Listar')->with('EditarCandidato', '402');
        }
    }

    public function list(Request $request)
    {

        // Busca todas as eleições para o dropdown
        $eleicoes = Eleicoes::orderBy('id', 'desc')->get();

        // Eleição selecionada ou padrão última
        $eleicaoId = $request->input('eleicao_id') ?? $eleicoes->first()->id;

        // Buscar candidatos da eleição selecionada com paginação
        $candidatos = Candidatos::with('Eleicoes')
            ->where('eleicoes_id', $eleicaoId)
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        //dd($candidatos[0])->Eleicoes()->id;
        return view('candidato.listar_candidato', compact('candidatos', 'eleicoes', 'eleicaoId'));
    }

    public function pdf_inscricao($id)
    {
        $pdfInscricao = candidatos::find($id);
        $pdf = Pdf::loadView('candidato.pdf_Inscricao', compact('pdfInscricao'));
        return $pdf->stream('Comprovante_Inscrição.pdf');
    }

    public function listagem_geral()
    {
        $ultimaEleicao = Eleicoes::max('id');
        $candidatos = candidatos::where('eleicoes_id', $ultimaEleicao)->orderBy('nome')->get();
        $eleicoes = eleicoes::all();
        return view('candidato.filter_candidato', compact('candidatos', 'eleicoes'));
    }

    public function filter_candidato(Request $request)
    {
        $candidatos = new candidatos();
        $eleicoes = eleicoes::all();
        $candidatos = $candidatos->where(function ($query) use ($request) {
            if ($request->eleicoes_id) {
                $query->where('eleicoes_id', "LIKE", "%{$request->eleicoes_id}%");
            }
            if ($request->id) {
                $query->where('id', "LIKE", "%{$request->id}%");
            }
            if ($request->cpf) {
                $cpfSanitizado = str_replace(array('.', '-'), '', $request->input('cpf'));
                $query->where('cpf', $cpfSanitizado);
            }
        })->get();
        return view('candidato.filter_candidato', compact('candidatos', 'eleicoes'));
    }

    public function pdf_listagem_geral(request $request)
    {
        $candidatos_ids = $request->input('listagem_candidatos');
        $eleicao_id = $request->input('eleicao_id');
        $candidatos_filtro = candidatos::whereIn('id', $candidatos_ids)->get();
        $eleicoes = eleicoes::find($eleicao_id);
        $pdf = Pdf::loadView('candidato.pdf_listagem_geral', compact('candidatos_filtro', 'eleicoes'));
        return $pdf->stream('ListagemGeral.pdf');
    }

    public function destroy($id)
    {
        $candidato = candidatos::find($id);
        if ($candidato) {
            $candidato->delete();
            return redirect()->back()->with('ExcluirCandidato', '402');
        }
    }
}
