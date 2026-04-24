<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Votacoes;
use App\Eleicoes;
use App\Eleitor;
use App\Candidatos;
use App\Usuario;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VotacaoController extends Controller
{
    public function index()
    {
        return view('votacao.login_votacao');
    }

    public function login_votacao(Request $request)
    {

        $eleicao_id = DB::table('eleicoes')->max('id');

        $eleicoes = DB::table('eleicoes')
            ->where('id', $eleicao_id)
            ->where('dt_votacao_de', '<=', Carbon::now())
            ->where('dt_votacao_ate', '>=', Carbon::now())
            ->first();

        if (!$eleicoes)
            return redirect()->route('Votacao_Index')->with('NaoVota', '402');

        $matricula = $request->input('matricula');
        $cpf = $request->input('cpf');
        if ($request->input('cpf')) {
            $cpfSanitizado = str_replace(array('.', '-'), '', $request->input('cpf'));
            $request->merge([
                'cpf' => $cpfSanitizado,
            ]);
        }

        $jaVotou = DB::table('votacoes')
            ->where('eleitor_matricula', $matricula)
            ->where('eleicoes_id', $eleicao_id)
            ->count();


        if ($jaVotou > 0)
            return redirect()->route('Votacao_Index')->with('JaVotou', '402');

        $import = DB::connection('banco_rh')->select(
            'select serv.CD_MATRICULA MATRICULA, p.NM_COMPLETO NOME, p.NR_CPF CPF, p.DT_NASCIMENTO, 
        vinc.CD_VINCULO, vinc.VINCULO,cargo.DS_CARGO, LOTACAO.DEPARTAMENTO, LOTACAO.SECRETARIA 
        from RHSLEO.WIZ_RHF_SERVIDORES serv, RHSLEO.WIZ_COR_PESSOAS p, RHSLEO.WIV_RHF_SERVIDORES_VINCULO vinc, RHSLEO.WIZ_RHF_CARGOS cargo, 
        RHSLEO.WIZ_RHF_SERVIDOR_CARGOS serv_carg,
         (select serv_custos.ID_SERV, custos.nome as DEPARTAMENTO, serv_custos.DT_INIC, serv_custos.DT_FINAL, sec.nome as SECRETARIA
        from RHSLEO.WIZ_RHF_SERVIDOR_CCUSTOS serv_custos, RHSLEO.WIZ_COR_CENTRO_CUSTOS custos, RHSLEO.WIZ_COR_CENTRO_CUSTOS sec
        where Serv_Custos.Ccst_Sequencia = Custos.Ccst_Sequencia
        AND custos.CCST_SEQUENCIA = serv_custos.CCST_SEQUENCIA
        and sec.ID_FILL (+)= custos.ID_FILL 
        and sec.CD_ESTRUT (+)= SUBSTR(custos.CD_ESTRUT,0,10)
        and serv_custos.IN_LOTACAO = ? 
        ) LOTACAO
        where serv.ID_PESS = p.ID_PESS
        and serv.ST_SERVIDOR = 1
        and vinc.ID_SERV = serv.ID_SERV
        and serv_carg.ID_SERV = serv.ID_SERV 
        and cargo.ID_CARG = serv_carg.ID_CARG 
        and serv_carg.DT_FINAL is null
        and LOTACAO.ID_SERV = serv.ID_SERV 
        and LOTACAO.DT_FINAL is null
        and serv.CD_MATRICULA = ?
        and p.NR_CPF = ?',
            ['E', $matricula, $cpfSanitizado]
        );
        if ($import) {
            $eleitor = new Eleitor;
            $eleitor->matricula = $import[0]->matricula;
            $eleitor->cpf = $import[0]->cpf;
            $eleitor->nome =  $import[0]->nome;
            $eleitor->dt_nascimento =  $import[0]->dt_nascimento;
            $eleitor->cd_vinculo = $import[0]->cd_vinculo;
            $eleitor->vinculo = $import[0]->vinculo;
            $eleitor->ds_cargo =  $import[0]->ds_cargo;
            $eleitor->departamento =  $import[0]->departamento;
            $eleitor->secretaria =  $import[0]->secretaria;
            Session::put('eleitor_nome', $eleitor->nome);
            Session::put('eleitor_cpf', $eleitor->cpf);
            $candidatos = candidatos::where('eleicoes_id', $eleicoes->id)->where('status', 1)->get();
            return view('votacao.votacao', ['eleitor' => $eleitor, 'eleicoes' => $eleicoes, 'candidatos' => $candidatos]);
        } else {
            return redirect()->back()->with('error', '404');
        }
    }

    public function logout_votacao(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('index');
    }

    public function create()
    {
        $votacao = DB::table('votacoes')->get();
        $candidatos = candidatos::orderBy('nome')->get();
        return view('votacao.votacao', compact('votacao', 'candidatos', 'eleitor_matricula', 'eleitor_lotacao', 'eleitor_cargo_funcao', 'eleitor_IP_acesso'));
    }

    public function mostrar_candidatos()
    {
        $candidatos = candidatos::all();
        return view('votacao.votacao', compact('candidatos'));
    }

    public function votocaojson()
    {
        $votacao = DB::table('votacoes')->get();
        $candidatos = candidatos::all();
        return response()->json($candidatos);
    }

    public function registrar_voto(Request $request)
    {
        $eleicoes = DB::table('eleicoes')
            ->where('dt_votacao_de', '<=', Carbon::now())
            ->where('dt_votacao_ate', '>=', Carbon::now())
            ->first();
        if (!$eleicoes) {
            return response()->json(['error' => 'Você está fora do periodo de votação!'], 400);
        }


        $cadastro = new votacoes();
        $tipo = $request->input('tipo');
        if ($tipo == 'V') {
            $cadastro->tipo_voto = 'V';
            $cadastro->voto_candidato_id = $request->input('voto_candidato_id');
        } else if ($tipo == 'B') {
            $cadastro->tipo_voto = 'B';
            $cadastro->voto_candidato_id = Null;
        } elseif ($tipo == 'N') {
            $cadastro->tipo_voto = 'N';
            $cadastro->voto_candidato_id = Null;
        }
        $cadastro->eleicoes_id = $request->input('eleicoes_id');
        $cadastro->eleitor_matricula = $request->input('matricula');
        $cadastro->eleitor_nome = $request->input('nome');
        $cadastro->eleitor_cpf = $request->input('cpf');
        $cadastro->eleitor_lotacao = $request->input('lotacao');
        $cadastro->eleitor_cargo_funcao = $request->input('cargo_funcao');
        // $cadastro->eleitor_IP_acesso = '1.1.2.55.0';
        $cadastro->eleitor_IP_acesso = $request->ip();
        // $cadastro->eleitor_IP_acesso = $request->input('eleitor_IP_acesso');
        $cadastro->save();
        return response()->json($cadastro);
    }

    public function comprovante($id)
    {
        $pdf_voto = votacoes::find($id);
        $eleicoes = eleicoes::all();

        $eleitor_nome = session()->get('eleitor_nome');
        $eleitor_cpf = session()->get('eleitor_cpf');

        $eleicao = eleicoes::find($pdf_voto->eleicoes_id);

        $pdf = Pdf::loadView('votacao.pdf_comprovante', compact('pdf_voto', 'eleicoes', 'eleitor_nome', 'eleitor_cpf', 'eleicao'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Comprovante_Voto.pdf');
    }

    public function resultados()
    {
        $ultima_eleicao = null;
        $exibir_mensagem = false;
        $votacao_candidatos = collect();
        $voto_branco = 0;
        $voto_nulo = 0;
        $voto_valido = 0;
        $nr_votos = 0;

        $ultima_eleicao = DB::table('eleicoes')->orderBy('created_at', 'desc')->first();

        if (!empty($ultima_eleicao)) {
            $exibir_mensagem = strtotime(date('Y-m-d H:i:s')) >= strtotime($ultima_eleicao->dt_resultados);
        }

        if ($ultima_eleicao && $exibir_mensagem) {
            $votacoes = Votacoes::all();
            $candidatos = candidatos::all();
            $resulta = 0;
            $dataatual = Carbon::now();

            $voto_branco = DB::table('votacoes')
                ->where('eleicoes_id', $ultima_eleicao->id)
                ->where('tipo_voto', 'B')
                ->count();

            $voto_nulo = DB::table('votacoes')
                ->where('eleicoes_id', $ultima_eleicao->id)
                ->where('tipo_voto', 'N')
                ->count();

            $voto_valido = DB::table('votacoes')
                ->where('eleicoes_id', $ultima_eleicao->id)
                ->where('tipo_voto', 'V')
                ->count();

            $nr_votos = DB::table('votacoes')
            ->where('eleicoes_id', $ultima_eleicao->id)
            ->count();

            $votacao_candidatos = DB::table('votacoes')
                ->join('candidatos', 'votacoes.voto_candidato_id', '=', 'candidatos.id')
                ->select(
                    'votacoes.voto_candidato_id',
                    'candidatos.nome',
                    'candidatos.cpf',
                    'candidatos.apelido',
                    'candidatos.lotacao',
                    'candidatos.matricula',
                    'candidatos.cargo_funcao',
                    DB::raw('count(*) as qtd_voto_candidato')
                )
                ->where('votacoes.eleicoes_id', $ultima_eleicao->id)
                ->where('tipo_voto', '=', 'V')
                ->groupBy(
                    'votacoes.voto_candidato_id',
                    'candidatos.nome',
                    'candidatos.cpf',
                    'candidatos.apelido',
                    'candidatos.lotacao',
                    'candidatos.matricula',
                    'candidatos.cargo_funcao'
                )
                ->orderBy('qtd_voto_candidato', 'DESC')
                ->get();
        }

        return view('votacao.resultados', compact(['votacao_candidatos', 'voto_branco', 'voto_nulo', 'voto_valido', 'nr_votos', 'ultima_eleicao', 'exibir_mensagem']));
    }

    public function acompanhamentoVotacao(Request $request)
    {
        $eleicoes = Eleicoes::orderBy('id', 'desc')->get();

        $eleicaoId = $request->input('eleicao_id') ?? $eleicoes->first()?->id;

        $votacao_candidatos = collect();
        $voto_branco = 0;
        $voto_nulo = 0;
        $voto_valido = 0;
        $nr_votos = 0;
        $exibir_mensagem = false;

        $eleicao = Eleicoes::find($eleicaoId);

        $voto_branco = DB::table('votacoes')
            ->where('eleicoes_id', $eleicaoId)
            ->where('tipo_voto', 'B')
            ->count();

        $voto_nulo = DB::table('votacoes')
            ->where('eleicoes_id', $eleicaoId)
            ->where('tipo_voto', 'N')
            ->count();

        $voto_valido = DB::table('votacoes')
            ->where('eleicoes_id', $eleicaoId)
            ->where('tipo_voto', 'V')
            ->count();

        $nr_votos = DB::table('votacoes')
            ->where('eleicoes_id', $eleicaoId)
            ->count();

        $votacao_candidatos = DB::table('votacoes')
                ->join('candidatos', 'votacoes.voto_candidato_id', '=', 'candidatos.id')
                ->select(
                    'votacoes.voto_candidato_id',
                    'candidatos.nome',
                    'candidatos.cpf',
                    'candidatos.apelido',
                    'candidatos.lotacao',
                    'candidatos.matricula',
                    'candidatos.cargo_funcao',
                    'candidatos.foto',
                    DB::raw('count(*) as qtd_voto_candidato')
                )
                ->where('votacoes.eleicoes_id', $eleicaoId)
                ->where('tipo_voto', '=', 'V')
                ->groupBy(
                    'votacoes.voto_candidato_id',
                    'candidatos.nome',
                    'candidatos.cpf',
                    'candidatos.apelido',
                    'candidatos.lotacao',
                    'candidatos.matricula',
                    'candidatos.cargo_funcao',
                    'candidatos.foto'
                )
                ->orderBy('qtd_voto_candidato', 'DESC')
                ->get();

        return view('admin.votacao.acompanhamento', compact(
            'eleicoes',
            'votacao_candidatos',
            'voto_branco',
            'voto_nulo',
            'voto_valido',
            'nr_votos',
            'exibir_mensagem',
            'eleicaoId'
        ));
    }

    public function pdf_resultados($id)
    {
        $eleicao = eleicoes::findOrFail($id);

        $voto_branco = DB::table('votacoes')
            ->where('eleicoes_id', $eleicao->id)
            ->where('tipo_voto', 'B')
            ->count();

        $voto_nulo = DB::table('votacoes')
            ->where('eleicoes_id', $eleicao->id)
            ->where('tipo_voto', 'N')
            ->count();
        
        $voto_valido = DB::table('votacoes')
            ->where('eleicoes_id', $eleicao->id)
            ->where('tipo_voto', 'V')
            ->count();

        $nr_votos = DB::table('votacoes')
            ->where('eleicoes_id', $eleicao->id)
            ->count();

        $votacao_candidatos = DB::table('votacoes')
            ->join('candidatos', 'votacoes.voto_candidato_id', '=', 'candidatos.id')
            ->where('votacoes.eleicoes_id', $eleicao->id)
            ->where('votacoes.tipo_voto', 'V')
            ->select(
                'candidatos.nome',
                'candidatos.cpf',
                'candidatos.apelido',
                'candidatos.lotacao',
                'candidatos.matricula',
                'candidatos.cargo_funcao',
                'candidatos.foto',
                DB::raw('count(*) as qtd_votos')
            )
            ->groupBy(
                'candidatos.nome',
                'candidatos.cpf',
                'candidatos.apelido',
                'candidatos.lotacao',
                'candidatos.matricula',
                'candidatos.cargo_funcao',
                'candidatos.foto'
            )
            ->orderByDesc('qtd_votos')
            ->get();

        $pdf = Pdf::loadView('votacao.pdf_resultados',
        compact(
            'eleicao', 
            'voto_branco',
            'voto_nulo',
            'voto_valido',
            'nr_votos', 
            'votacao_candidatos'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Resultado.pdf');
    }

    public function resultados_json()
    {
        $data_atual = date('Y-m-d H:i:s');

        $eleicao = DB::table('eleicoes')->where('dt_resultados', '<=', $data_atual)->orderBy('dt_resultados', 'desc')->first();

        if ($eleicao) {
            $votos = DB::table('votacoes')->where('eleicoes_id', $eleicao->id)->whereNotNull('voto_candidato_id')->get();
            $votos_validos = $votos->filter(function ($voto) {
                return $voto->tipo_voto == 'V';
            });
            $candidatos_votos = $votos_validos->groupBy('voto_candidato_id')->map(function ($votos, $candidato_id) {
                $candidato = Candidatos::find($candidato_id);
                $total_votos = $votos->count();

                return [
                    'candidato' => $candidato,
                    'foto' => $candidato->foto,
                    'nome' => $candidato->nome,
                    'apelido' => $candidato->apelido,
                    'matricula' => $candidato->matricula,
                    'cargo_funcao' => $candidato->cargo_funcao,
                    'total_votos' => $total_votos,
                    'vinculo' => $candidato->vinculo,

                ];
            })->sortByDesc('total_votos')->values();

            return response()->json($candidatos_votos);
        } else {
            return response()->json(['message' => '<h2>Não há eleições concluídas no momento.</h2>']);
        }
    }

    public function verificarPeriodoVotacao()
    {
        $eleicoes = DB::table('eleicoes')
            ->where('dt_votacao_de', '<=', Carbon::now())
            ->where('dt_votacao_ate', '>=', Carbon::now())
            ->first();

        if (!$eleicoes) {
            return response()->json(['error' => 'Você está fora do período de votação!'], 400);
        }

        return response()->json(['success' => true], 200);
    }
}
