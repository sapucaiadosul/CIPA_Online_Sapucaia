<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Eleicoes;
use App\Anexos;
use App\Votacoes;
use App\Eleitor;
use App\Candidatos;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class EleicaoController extends Controller
{
    public function index()
    {
        $eleicoes = eleicoes::all();
        return view('admin.eleicoes', compact('eleicoes'));
    }

    public function create()
    {
        $cadastro = DB::table('eleicoes')->get();
        return view('admin.eleicao.eleicoes', compact('cadastro'));
    }

    public function store(Request $request)
    {
        $eleicoes = new eleicoes();
        $eleicoes->descricao_eleicao = $request->input('descricao_eleicao');
        $eleicoes->dt_vigencia_de = $request->input('dt_vigencia_de');
        $eleicoes->dt_vigencia_ate = $request->input('dt_vigencia_ate');
        $eleicoes->numero_indicados = $request->input('numero_indicados');
        $eleicoes->numero_nao_indicados = $request->input('numero_nao_indicados');
        $eleicoes->numero_eleitos = $request->input('numero_eleitos');
        $eleicoes->dt_inscricao_de = $request->input('dt_inscricao_de');
        $eleicoes->dt_inscricao_ate = $request->input('dt_inscricao_ate');
        $eleicoes->dt_votacao_de = $request->input('dt_votacao_de');
        $eleicoes->dt_votacao_ate = $request->input('dt_votacao_ate');
        $eleicoes->dt_resultados = $request->input('dt_resultados');
        $eleicoes->dt_edital_nominal = $request->input('dt_edital_nominal');
        $eleicoes->obs_anexos = $request->input('obs_anexos');

        $aux_dt_vigencia_de = Carbon::parse($request->input('dt_vigencia_de'));
        $aux_dt_vigencia_ate = Carbon::parse($request->input('dt_vigencia_ate'));
        if ($aux_dt_vigencia_de > $aux_dt_vigencia_ate) {
            return redirect()->back()->with('DatasVigência', '402')->withinput();
        }
        $aux_dt_inscricao_de = Carbon::parse($request->input('dt_inscricao_de'));
        $aux_dt_inscricao_ate = Carbon::parse($request->input('dt_inscricao_ate'));
        if ($aux_dt_inscricao_de > $aux_dt_inscricao_ate) {
            return redirect()->back()->with('DatasInscrição', '402')->withinput();
        }
        $aux_dt_votacao_de = Carbon::parse($request->input('dt_votacao_de'));
        $aux_dt_votacao_ate = Carbon::parse($request->input('dt_votacao_ate'));
        if ($aux_dt_votacao_de > $aux_dt_votacao_ate) {
            return redirect()->back()->with('DatasVotação', '402')->withinput();
        }
        $aux_dt_resultados = Carbon::parse($request->input('dt_resultados'));
        $aux_dt_votacao_ate = Carbon::parse($request->input('dt_votacao_ate'));
        if ($aux_dt_votacao_ate > $aux_dt_resultados) {
            return redirect()->back()->with('DataResultado', '402')->withinput();
        }

        $validator = Validator::make(
            $request->all(),
            [
                'arquivo.*' =>  'mimes:pdf|max:3072'
            ],
            [
                'arquivo.*.max' => 'Os arquivos anexados devem possuir no máximo 3 Megabytes.',
                'arquivo.*.mimes' => 'Os arquivos anexados devem ser no formato PDF.'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $eleicoes->save();
        if (!empty($request->allFiles()['arquivo'])) {
            for ($i = 0; $i < count($request->allFiles()['arquivo']); $i++) {
                $arquivo = $request->allFiles()['arquivo'][$i];
                $anexos = new anexos();
                $anexos->origem_id = $eleicoes->id;
                $anexos->nome_original = $arquivo->getClientOriginalName();
                $anexos->arquivo = $arquivo->store('arquivos/' . $eleicoes->id);
                $anexos->save();
            }
        }
        return redirect()->route('Eleicoes_Listar')->with('CadastrarEleicao', '402');
    }

    public function edit($id)
    {
        $eleicoes = eleicoes::find($id);
        $anexos =  anexos::where('origem_id', $id)->get();

       // $candidatos = candidatos::where('eleicoes_id',$id)->orderBy('nome')->get();
        $eleicoes_filtro = eleicoes::all();

        $candidatos_eleicao = candidatos::where('eleicoes_id',$id)->get();

        $votacoes = Votacoes::where('eleicoes_id',$id)->get();
        $candidatos = candidatos::where('eleicoes_id',$id)->get();
        $resulta = 0;
        $dataatual = Carbon::now();
        $voto_branco = DB::table('votacoes')
            ->select(DB::raw('count(*) as tipo_voto'))
            ->where('tipo_voto', '=', 'B')
            ->where('eleicoes_id', '=', $id)
            ->value('qtd_voto_branco');
        $voto_nulo = DB::table('votacoes')
            ->select(DB::raw('count(*) as tipo_voto'))
            ->where('tipo_voto', '=', 'N')
            ->where('eleicoes_id', '=', $id)
            ->value('qtd_voto_nulo');    
        $votacao_candidatos = DB::table('votacoes')
            ->join('candidatos', 'votacoes.voto_candidato_id', '=', 'candidatos.id')
            ->select('votacoes.voto_candidato_id','candidatos.nome','candidatos.cpf', 'candidatos.apelido',
             'candidatos.lotacao','candidatos.matricula','candidatos.cargo_funcao',
              DB::raw ('count(*) as qtd_voto_candidato'))
            ->where('tipo_voto', '=', 'V')
            ->where('votacoes.eleicoes_id', '=', $id)
            ->groupBy('votacoes.voto_candidato_id','candidatos.nome','candidatos.cpf','candidatos.apelido',
             'candidatos.lotacao','candidatos.matricula','candidatos.cargo_funcao')
            ->orderBy('qtd_voto_candidato','DESC')
            ->get();  
        $nr_votos = votacoes::where('eleicoes_id', '=', $id)->count();

        return view('admin.eleicao.abas_edit_eleicoes', compact('eleicoes', 'anexos','candidatos','eleicoes_filtro','candidatos_eleicao','votacao_candidatos','voto_branco','voto_nulo','nr_votos'));
    }

    

    public function update(Request $request)
    {
        $eleicoes = eleicoes::find($request->eleicoes_id);

        if (!$eleicoes) {
            return redirect()->back();
        }

        $validator = Validator::make(
            $request->all(),
            [
                'arquivo.*' => 'mimes:pdf|max:3072'
            ],
            [
                'arquivo.*.max' => 'Os arquivos anexados devem possuir no máximo 3 Megabytes.',
                'arquivo.*.mimes' => 'Os arquivos anexados devem ser no formato PDF.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('arquivo')) {

            foreach ($request->file('arquivo') as $arquivo) {

                $path = 'arquivos/' . $eleicoes->id;

                $arquivoSalvo = $arquivo->store($path);

                $eleicoes_anexos = new anexos();
                $eleicoes_anexos->origem_id = $eleicoes->id;
                $eleicoes_anexos->nome_original = $arquivo->getClientOriginalName();
                $eleicoes_anexos->arquivo = $arquivoSalvo;
                $eleicoes_anexos->save();
            }
        }

        $request->session()->put('AtualizarParamEleicoes', [
            $eleicoes = $eleicoes->update([
                'descricao_eleicao' => $request->descricao_eleicao,
                'dt_vigencia_de' => $request->dt_vigencia_de,
                'dt_vigencia_ate' => $request->dt_vigencia_ate,
                'numero_indicados' => $request->numero_indicados,
                'numero_nao_indicados' => $request->numero_nao_indicados,
                'numero_eleitos' => $request->numero_eleitos,
                'dt_inscricao_de' => $request->dt_inscricao_de,
                'dt_inscricao_ate' => $request->dt_inscricao_ate,
                'dt_votacao_de' => $request->dt_votacao_de,
                'dt_votacao_ate' => $request->dt_votacao_ate,
                'dt_resultados' => $request->dt_resultados,
                'dt_edital_nominal' => $request->dt_edital_nominal,
                'obs_anexos' => $request->obs_anexos,
            ])
        ]);

        $aux_dt_vigencia_de = Carbon::parse($request->input('dt_vigencia_de'));
        $aux_dt_vigencia_ate = Carbon::parse($request->input('dt_vigencia_ate'));
        if ($aux_dt_vigencia_de > $aux_dt_vigencia_ate) {
            return redirect()->back()->with('DatasVigência', '402')->withinput();
        }

        $aux_dt_inscricao_de = Carbon::parse($request->input('dt_inscricao_de'));
        $aux_dt_inscricao_ate = Carbon::parse($request->input('dt_inscricao_ate'));
        if ($aux_dt_inscricao_de > $aux_dt_inscricao_ate) {
            return redirect()->back()->with('DatasInscrição', '402')->withinput();
        }

        $aux_dt_votacao_de = Carbon::parse($request->input('dt_votacao_de'));
        $aux_dt_votacao_ate = Carbon::parse($request->input('dt_votacao_ate'));
        if ($aux_dt_votacao_de > $aux_dt_votacao_ate) {
            return redirect()->back()->with('DatasVotação', '402')->withinput();
        }
        
        // Deve permitir na Alteração de Datas:
        // $aux_dt_resultados = Carbon::parse($request->input('dt_resultados'));
        // $aux_dt_votacao_ate = Carbon::parse($request->input('dt_votacao_ate'));
        // if ($aux_dt_votacao_ate > $aux_dt_resultados) {
        //     return redirect()->back()->with('DataResultado', '402')->withinput();
        // }
        return redirect()->back()->with('EditarEleicao', '402')->withinput();
    }

    public function baixar_anexos($id)
    {
        $arquivo = anexos::where('id', '=', $id)->get()->first();
        $eleicoes = eleicoes::find($arquivo->origem_id);
        return Response::download(storage_path('app/public/' . $arquivo->arquivo), str_replace('/', '', $eleicoes->descricao_eleicao) . '.pdf');
    }

    public function list()
    {
        $eleicoes = eleicoes::all();
        return view('admin.eleicao.listar_eleicoes', compact('eleicoes'));
    }

    public function destroy($id)
    {
        $eleicoes = eleicoes::find($id);
        if ($eleicoes) {
            $eleicoes->delete();
            return redirect()->back()->with('Excluir_Eleicoes', '402');
        }
    }
}
