<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Servidor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImportacaoController extends Controller
{
    public function index()
    {
        return view('admin.importacao.index');
    }

    public function importar_servidor(Request $request)
    {
        if (!$request->hasFile('arquivo')) {
            return redirect()->back()->with('SemArquivo', true);
        }

        $extensao = $request->file('arquivo')->getClientOriginalExtension();

        if (!in_array($extensao, ['xls', 'xlsx', 'csv', 'ods'])) {
            return redirect()->back()->with('ArquivoInvalido', true);
        }

        $arquivo = $request->file('arquivo');

        $spreadsheet = IOFactory::load($arquivo->getPathname());
        $dataArray = $spreadsheet->getSheet(0)->toArray();

        foreach($dataArray as $index => $coluna){
            if ($index === 0) continue;

            Servidor::updateOrCreate([
                'nome' => $coluna[0],
                'matricula' => preg_replace('/\D/', '', $coluna[1]),
                'cpf' => preg_replace('/\D/', '', $coluna[2]),
                'dt_nascimento' => Carbon::createFromFormat('d/m/Y', $coluna[3])->format('Y-m-d'),
                'vinculo' => $coluna[4],
            ]);
        }

        return redirect('/importacoes')->with('ImportacaoConcluida', true);
    }
}
