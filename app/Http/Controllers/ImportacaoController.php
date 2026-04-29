<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Servidor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportacaoController extends Controller
{
    private function normalizarTextoCsv(?string $valor): string
    {
        $valor = (string) $valor;

        if ($valor === '') {
            return '';
        }

        if (!mb_check_encoding($valor, 'UTF-8')) {
            $valorConvertido = @mb_convert_encoding($valor, 'UTF-8', 'Windows-1252,ISO-8859-1,UTF-8');

            if ($valorConvertido !== false) {
                $valor = $valorConvertido;
            }
        }

        return trim($valor);
    }

    private function normalizarCabecalho(?string $valor): string
    {
        $valor = $this->normalizarTextoCsv($valor);
        $valor = preg_replace('/^\xEF\xBB\xBF/', '', $valor);
        $valor = str_replace([' ', '-'], '_', $valor);

        return mb_strtolower($valor);
    }

    private function obterValorPorAlias(array $registro, array $aliases): string
    {
        foreach ($aliases as $alias) {
            if (array_key_exists($alias, $registro) && $registro[$alias] !== null) {
                return $this->normalizarTextoCsv((string) $registro[$alias]);
            }
        }

        return '';
    }

    private function detectarDelimitadorCsv(string $caminhoArquivo): string
    {
        $handle = fopen($caminhoArquivo, 'r');
        $primeiraLinha = $handle ? (fgets($handle) ?: '') : '';

        if ($handle) {
            fclose($handle);
        }

        $delimitadores = [
            ',' => substr_count($primeiraLinha, ','),
            ';' => substr_count($primeiraLinha, ';'),
            "\t" => substr_count($primeiraLinha, "\t"),
        ];

        arsort($delimitadores);

        return array_key_first($delimitadores) ?: ',';
    }

    private function lerLinhasCsv(string $caminhoArquivo): array
    {
        $linhas = [];
        $delimitador = $this->detectarDelimitadorCsv($caminhoArquivo);
        $handle = fopen($caminhoArquivo, 'r');

        if (!$handle) {
            return $linhas;
        }

        while (($linha = fgetcsv($handle, 0, $delimitador, '"')) !== false) {
            if (count($linha) === 1 && is_string($linha[0] ?? null)) {
                $linha = $this->normalizarLinhaCsvEncapsulada($linha[0], $delimitador);
            }

            if (isset($linha[0])) {
                $linha[0] = preg_replace('/^\xEF\xBB\xBF/', '', $this->normalizarTextoCsv((string) $linha[0]));
            }

            foreach ($linha as $indice => $valor) {
                if (is_string($valor)) {
                    $linha[$indice] = $this->normalizarTextoCsv($valor);
                }
            }

            $linhas[] = $linha;
        }

        fclose($handle);

        return $linhas;
    }

    private function normalizarLinhaCsvEncapsulada(string $linha, string $delimitador): array
    {
        $linha = $this->normalizarTextoCsv($linha);

        if (str_starts_with($linha, '"') && str_ends_with($linha, '"')) {
            $linha = substr($linha, 1, -1);
        }

        $linha = str_replace('""', '"', $linha);

        return str_getcsv($linha, $delimitador, '"');
    }

    private function sincronizarSequenciaServidores(): void
    {
        if (config('database.default') !== 'pgsql') {
            return;
        }

        DB::statement(
            "SELECT setval(
                pg_get_serial_sequence('servidores', 'id'),
                COALESCE((SELECT MAX(id) FROM servidores), 1),
                true
            )"
        );
    }

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
        $caminhoArquivo = $arquivo->getPathname();

        if ($extensao === 'csv') {
            $dataArray = $this->lerLinhasCsv($caminhoArquivo);
        } else {
            $spreadsheet = IOFactory::load($caminhoArquivo);
            $dataArray = $spreadsheet->getSheet(0)->toArray();
        }

        $cabecalho = array_map(fn ($coluna) => $this->normalizarCabecalho($coluna), $dataArray[0] ?? []);
        $importados = 0;
        $ignorados = 0;

        $this->sincronizarSequenciaServidores();

        foreach($dataArray as $index => $coluna){
            if ($index === 0) continue;
            if (empty(array_filter($coluna, fn ($valor) => $valor !== null && $valor !== ''))) continue;

            $registro = [];
            foreach ($cabecalho as $posicao => $nomeColuna) {
                if ($nomeColuna === '') {
                    continue;
                }

                $registro[$nomeColuna] = $coluna[$posicao] ?? null;
            }

            $nome = $this->obterValorPorAlias($registro, ['nome', 'nm_nome']);
            $matricula = preg_replace('/\D/', '', $this->obterValorPorAlias($registro, ['matricula', 'nr_matricula']));
            $cpf = preg_replace('/\D/', '', $this->obterValorPorAlias($registro, ['cpf', 'nr_cpf']));
            $vinculo = $this->obterValorPorAlias($registro, ['vinculo', 'cd_vinculo', 'ds_vinculo']);
            $dataBruta = $this->obterValorPorAlias($registro, ['dt_nascimento', 'data_nascimento', 'nascimento']);

            if ($nome === '' && count($coluna) >= 6) {
                $temIdNaPrimeiraColuna = $this->normalizarCabecalho($dataArray[0][0] ?? '') === 'id';
                $offset = $temIdNaPrimeiraColuna ? 1 : 0;

                $nome = $this->normalizarTextoCsv((string) ($coluna[$offset] ?? ''));
                $matricula = preg_replace('/\D/', '', (string) ($coluna[$offset + 1] ?? ''));
                $cpf = preg_replace('/\D/', '', (string) ($coluna[$offset + 2] ?? ''));
                $dataBruta = $this->normalizarTextoCsv((string) ($coluna[$offset + 3] ?? ''));
                $vinculo = $this->normalizarTextoCsv((string) ($coluna[$offset + 4] ?? ''));
            }

            if ($nome === '' || $matricula === '' || $cpf === '' || $dataBruta === '' || $vinculo === '') {
                $ignorados++;
                continue;
            }

            $dataNascimento = str_contains($dataBruta, '/')
                ? Carbon::createFromFormat('d/m/Y', $dataBruta)->format('Y-m-d')
                : Carbon::createFromFormat('Y-m-d', $dataBruta)->format('Y-m-d');

            Servidor::updateOrCreate([
                'matricula' => $matricula,
            ], [
                'nome' => $nome,
                'cpf' => $cpf,
                'dt_nascimento' => $dataNascimento,
                'vinculo' => $vinculo,
            ]);

            $importados++;
        }

        return redirect('/importacoes')->with([
            'ImportacaoConcluida' => true,
            'Importados' => $importados,
            'Ignorados' => $ignorados,
        ]);
    }
}
