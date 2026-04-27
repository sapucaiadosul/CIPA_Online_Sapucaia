<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Votacoes;
use App\Eleicoes;
use App\Eleitor;
use App\Candidatos;
use App\Servidor;
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

        if ($request->input('cpf')) {
            $cpfSanitizado = str_replace(array('.', '-'), '', $request->input('cpf'));
            $request->merge([
                'cpf' => $cpfSanitizado,
            ]);
        }

        $jaVotou = DB::table('votacoes')
            ->join('servidores', 'votacoes.servidor_id', '=', 'servidor_id')
            ->where('servidores.matricula', $matricula)
            ->where('eleicoes_id', $eleicao_id)
            ->count();


        if ($jaVotou > 0)
            return redirect()->route('Votacao_Index')->with('JaVotou', '402');

        $servidor = Servidor::where('matricula', $matricula)
            ->where('cpf', $cpfSanitizado)
            ->first();

        if ($servidor) {
            Session::put('servidor_id', $servidor->id);
            $candidatos = candidatos::where('eleicoes_id', $eleicoes->id)->where('status', 1)->get();
            return view('votacao.votacao', ['servidor' => $servidor, 'eleicoes' => $eleicoes, 'candidatos' => $candidatos]);
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
        $cadastro->servidor_id = $request->input('servidor_id');
        $cadastro->servidor_IP_acesso = $request->ip();
        $cadastro->save();
        return response()->json($cadastro);
    }

    public function comprovante($id)
    {
        $servidor_id = session()->get('servidor_id');

        $pdf_voto = votacoes::with('servidor')
        ->where('servidor_id', $servidor_id)
        ->first();

        $eleicao = eleicoes::find($pdf_voto->eleicoes_id);

        $pdf = Pdf::loadView('votacao.pdf_comprovante', compact('pdf_voto', 'eleicao'));
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

        $pdf = Pdf::loadView(
            'votacao.pdf_resultados',
            compact(
                'eleicao',
                'voto_branco',
                'voto_nulo',
                'voto_valido',
                'nr_votos',
                'votacao_candidatos'
            )
        );

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
