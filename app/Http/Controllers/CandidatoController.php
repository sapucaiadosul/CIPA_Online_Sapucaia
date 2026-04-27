<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidatos;
use App\Eleicoes;
use App\Http\Requests\CandidatoRequest;
use App\Servidor;
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
        $datanasc = Carbon::createFromFormat('Y-m-d', $datanasc);

        $servidor = Servidor::where('matricula', $matricula)
            ->whereDate('dt_nascimento', $datanasc)
            ->first();

        $candidatoAutenticado = new candidatos;

        if ($servidor) {
            $candidatoAutenticado->matricula = $servidor->matricula;
            $candidatoAutenticado->cpf = $servidor->cpf;
            $candidatoAutenticado->nome = $servidor->nome;
            $dt_nascimento = \Carbon\Carbon::parse($servidor->dt_nascimento)->format('Y-m-d');
            $candidatoAutenticado->dt_nascimento = $dt_nascimento;
            $candidatoAutenticado->vinculo = $servidor->vinculo;
        } else {
            return redirect()->back()->with('NaoAchou', '404');
        }

        if ($candidatoAutenticado->vinculo != 'Estatutario' && $candidatoAutenticado->vinculo != 'CLT Urb.Indet.P.Jur.') {
            return redirect()->back()->with('VinculoNaoPermitido', '404');
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
