@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')

@if(session('EditarEleicao'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Dados da Eleição Alterados com Sucesso!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('DatasVigência'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Datas de Vigência Incoerentes!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('DatasInscrição'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Datas de Inscrição Incoerentes!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('DatasVotação'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Datas de Votação Incoerentes!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('DataResultado'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Data do Resultado deve ser maior que Data de Votação até',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
<div>




    <body>
        <div class="card">
            <ul class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-manutencao-eleicao-tab" data-bs-toggle="tab"
                        data-bs-target="#pills-manutencao-eleicao" type="button" role="tab"
                        aria-controls="pills-manutencao-eleicao" aria-selected="true">MANUTENÇÃO DE DADOS DAS ELEIÇÕES</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-candidatos-inscritos-tab" data-bs-toggle="tab"
                        data-bs-target="#pills-candidatos-inscritos" type="button" role="tab"
                        aria-controls="pills-candidatos-inscritos" aria-selected="false">Candidatos Inscritos</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-resultado-tab" data-bs-toggle="tab" data-bs-target="#pills-resultado"
                        type="button" role="tab" aria-controls="pills-resultado" aria-selected="false">Resultado Votação</button>
                </li>

            
            </ul>

            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-manutencao-eleicao" role="tabpanel"
                    aria-labelledby="manutencao-eleicao-tab">

                  



                    <div class="card">
                        <div class="card-header">
                            <h4 class="col-12 modal-title text-center">MANUTENÇÃO DE DADOS DAS ELEIÇÕES</h4>
                        </div>
                        
                        <form method="POST" action="{{ route('Eleicoes_Update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$eleicoes->id}}" name="eleicoes_id">
                        <div class="form-group col-md-12">
                            @if($errors->all())
                                @foreach($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="container col-md-12">
                                <div class="form-group col-md-12">
                                    <div class="form-row">
                                    <div class="form-group col-md-3">
                                            <label for="descricao_eleicao" class="control-label">Descrição da Eleição:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="descricao_eleicao" name="descricao_eleicao" required
                                                    placeholder="Descrição da Eleição" value="{{ isset($eleicoes->descricao_eleicao) ? $eleicoes->descricao_eleicao : old('descricao_eleicao') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="numero_indicados" class="control-label">Número de Indicados:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="numero_indicados" name="numero_indicados"  disabled
                                                    placeholder="Número de Indicados" value="{{ isset($eleicoes->numero_indicados) ? $eleicoes->numero_indicados : old('numero_indicados') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="numero_nao_indicados" class="control-label">Número de Inscritos(Não Indicados):</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="numero_nao_indicados" name="numero_nao_indicados"  disabled
                                                    placeholder="Número de Inscritos (Não Indicados)" value="{{ isset($eleicoes->numero_nao_indicados) ? $eleicoes->numero_nao_indicados : old('numero_nao_indicados') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="numero_eleitos" class="control-label">Número de Eleitos:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="numero_eleitos" name="numero_eleitos"  disabled
                                                    placeholder="Número de Eleitos" value="{{ isset($eleicoes->numero_eleitos) ? $eleicoes->numero_eleitos : old('numero_eleitos') }}">
                                            </div>
                                        </div>
                
                                        <div class="form-group col-md-3">
                                            <label for="dt_vigencia_de" class="control-label">Data/Hora de Vigência de:</label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control" id="dt_vigencia_de" name="dt_vigencia_de"
                                                    placeholder="Data/Hora de Vigência de" value="{{ isset($eleicoes->dt_vigencia_de) ? $eleicoes->dt_vigencia_de : old('dt_vigencia_de') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="dt_vigencia_ate" class="control-label">Data/Hora de Vigência até:</label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control" id="dt_vigencia_ate" name="dt_vigencia_ate"
                                                    placeholder="Data/Hora de Vigência até" value="{{ isset($eleicoes->dt_vigencia_ate) ? $eleicoes->dt_vigencia_ate : old('dt_vigencia_ate') }}">
                                            </div>
                                        </div>
                
                                        <div class="form-group col-md-3">
                                            <label for="dt_inscricao_de" class="control-label">Data/Hora de Inscrição de:</label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control" id="dt_inscricao_de" name="dt_inscricao_de"
                                                    placeholder="Data/Hora de Inscrição de" value="{{ isset($eleicoes->dt_inscricao_de) ? $eleicoes->dt_inscricao_de : old('dt_inscricao_de') }}">
                                            </div>
                                        </div>
                 
                                        <div class="form-group col-md-3">
                                            <label for="dt_inscricao_ate" class="control-label">Data/Hora de Inscrição até:</label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control" id="dt_inscricao_ate" name="dt_inscricao_ate"
                                                    placeholder="Data/Hora de Inscrição até" value="{{ isset($eleicoes->dt_inscricao_ate) ? $eleicoes->dt_inscricao_ate : old('dt_inscricao_ate') }}">
                                            </div>
                                        </div>
                
                                        <div class="form-group col-md-3">
                                            <label for="dt_votacao_de" class="control-label">Data/Hora de Votação de:</label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control" id="dt_votacao_de" name="dt_votacao_de"
                                                    placeholder="Data/Hora de Votação de" value="{{ isset($eleicoes->dt_votacao_de) ? $eleicoes->dt_votacao_de : old('dt_votacao_de') }}">
                                            </div>
                                        </div>
                         
                                        <div class="form-group col-md-3">
                                            <label for="dt_votacao_ate" class="control-label">Data de Votação até:</label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control" id="dt_votacao_ate" name="dt_votacao_ate"
                                                    placeholder="Data/Hora de Votação até" value="{{ isset($eleicoes->dt_votacao_ate) ? $eleicoes->dt_votacao_ate : old('dt_votacao_ate') }}">
                                            </div>
                                        </div>
                
                                        <div class="form-group col-md-3">
                                            <label for="dt_resultados" class="control-label">Data/Hora dos Resultados:</label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control" id="dt_resultados" name="dt_resultados"
                                                    placeholder="Data/Hora dos Resultados" value="{{ isset($eleicoes->dt_resultados) ? $eleicoes->dt_resultados : old('dt_resultados') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="dt_edital_nominal" class="control-label">Data do Edital Nominal dos Candidatos:</label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control" id="dt_edital_nominal" name="dt_edital_nominal"
                                                    placeholder="Data do Edital Nominal dos Candidatos" value="{{ isset($eleicoes->dt_edital_nominal) ? $eleicoes->dt_edital_nominal : old('dt_edital_nominal') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="obs_anexos" class="control-label">Observações sobre Anexos:</label>
                                                <div class="input-group ">
                                                    <input type="text" class="form-control" name="obs_anexos" id="obs_anexos"
                                                        value="{{ isset($eleicoes->obs_anexos) ? $eleicoes->obs_anexos : old('obs_anexos') }}">
                                                </div>
                                            </div>
                                        </div>    
                                        <table class="table table-hover">
                                        <thead align="center">
                                            <tr>
                                                <th>Id</th>
                                                <th>Nome Arquivo Original</th>
                                                <th>Data de Envio</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody align="center">
                                            @foreach ($anexos as $anexos)
                                                <tr>
                                                    <td>{{$anexos->id}}</td>
                                                    <td>{{$anexos->nome_original}}</td>
                                                    <td>{{$anexos->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                    <a href="{{ route('Eleicoes_BaixarAnexos', $anexos->id) }}" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-download"></i> Download </a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                    </div>
                                </div>    
                            </div>
                            <div class="form-group col-md-6">
                                <label for="arquivo" class="custom-file-upload">
                                    <a class="btn btn-outline-secondary btn-sm"><i class="fa fa-cloud-upload"></i> Anexar Documentos</a>
                                </label>
                                <input style="display:none" type="file" name="arquivo[]" class="custom-file-unput" id="arquivo" multiple>
                                <div ID="arquivos_selecionados"></div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Salvar</button>
                                <a href="{{route('Eleicoes_Listar')}}" type="button" class="btn btn-outline-secondary btn-sm">Voltar p/ Lista/Manutenção da Eleição</a>
                            </div>
                        </form>
                        </div>    
                    </div>
                </div>
            </div>
            
                <div class="tab-pane fade" id="pills-candidatos-inscritos" role="tabpanel" aria-labelledby="pills-candidatos-inscritos-tab">
                
                    <div class="card">
                        <div class="card-header">
                            <h5 class="col-12 modal-title text-left">Candidatos Inscritos Nesta Eleição</h5>
                         
                        </div>
                        <h6 class="col-12 modal-title text-center"></h6>
                        <div class="container col-md-12">
                            <div class="container-fluid no-padding table-responsive-sm">
                                <table class="table table-striped nowrap" id="exemplo">
                                    <thead align="center">
                                        <tr>
                                            <th>Nº Inscrição</th>
                                            <th>Matrícula</th>
                                            <th>Nome Completo</th>
                                            <th>Apelido</th>
                                            <th>Cargo/Função</th>
                                            <th>Lotação</th>
                                        </tr>
                                    </thead>
                                    <tbody align="center">
                                        @foreach ($candidatos_eleicao as $candidato)
                                        <tr>
                                            <td>{{$candidato->id}}</td>
                                            <td>{{$candidato->matricula}}</td>
                                            <td>{{$candidato->nome}}</td>
                                            <td>{{$candidato->apelido}}</td>
                                            <td>{{$candidato->cargo_funcao}}</td>
                                            <td>{{$candidato->lotacao}}</td>
                                            <td>
                                              
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="container col-md-12">
                                </div>
                            </div>
                        </div>
                   
                    </div>
                </div>
          
       


                    <div class="tab-pane fade" id="pills-resultado" role="tabpanel" aria-labelledby="pills-resultado-tab">
               
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="modal-title mb-0">
                                RESULTADOS DA ELEIÇÃO
                            </h5>

                            <a href="{{ route('Eleicoes_pdfResultado', $eleicoes->id) }}"
                            class="btn btn-primary btn-sm mt-1" target="_blank" rel="noopener noreferrer">
                                <i class="fa fa-download me-1"></i>Baixar Resultado
                            </a>
                        </div>

                        <h5 class="col-12 modal-title text-center mt-2">
                            TOTAL DE VOTOS APURADOS: {{ $nr_votos }}
                        </h5>

                        <div class="container col-md-12">
                            <div class="container-fluid no-padding table-responsive-sm">
                                <table class="table table-striped nowrap" style="width:100%" id="exemplo">
                                    <thead align="center">
                                        <tr>
                                            <th>RESULTADO</th>
                                            <th>Nome Completo</th>
                                            <th>Apelido</th>
                                            <th>CPF</th>
                                            <th>Matrícula</th>
                                            <th>Lotação</th>
                                            <th>Cargo/Função</th>
                                            <th>Qtd.Votos</th>
                                        </tr>
                                    </thead>
                                    <tbody align="center">
                                        @foreach ($votacao_candidatos as $totalvotos)
                                        <tr>
                                            <td>
                                                @if($loop->index<6)
                                                    TITULAR ELEITO
                                                @elseif($loop->index >=6 && $loop->index <11)
                                                    SUPLENTE
                                                @endif
                                            </td>
                                            <td>{{$totalvotos->nome}}</td>
                                            <td>{{$totalvotos->apelido}}</td>
                                        
                                            <td> {{substr($totalvotos->cpf,0,3).'.'.substr($totalvotos->cpf,3,3).'.'.substr($totalvotos->cpf,6,3).'-'.substr($totalvotos->cpf,9,2)}}</td>
                                            <td>{{$totalvotos->matricula}}</td>
                                            <td>{{$totalvotos->lotacao}}</td>
                                            <td>{{$totalvotos->cargo_funcao}}</td>
                                            <td><strong>{{$totalvotos->qtd_voto_candidato}}</strong></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th><strong>VOTOS EM BRANCO</strong></th>
                                            <th>BRANCOS</th>
                                            <th>---</th>
                                            <th>---</th>
                                            <th>---</th>
                                            <th>---</th>
                                            <th>---</th>
                                            <td><strong>{{$voto_branco}}</strong></td>
                                        </tr>
                                        <tr>
                                            <th><strong>VOTOS NULOS</strong></th>
                                            <th>NULOS</th>
                                            <th>---</th>
                                            <th>---</th>
                                            <th>---</th>
                                            <th>---</th>
                                            <th>---</th>
                                            <td><strong>{{$voto_nulo}}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                         </div>
                    </div>   
    </body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

{{-- <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/vendor/jquery/jquery-mask/jquery.mask.min.js') }}"></script> --}}

<script>
//  $(document).ready(function () {
//     $('#exemplo').DataTable({
//         select: false,
//         responsive: true,
//         "order": [
//             [0, "asc"]
//         ],
//         "info": false,
//         "sLengthMenu": false,
//         "bLengthChange": false,
//         "oLanguage": {

//             "sEmptyTable": "Nenhum registro encontrado",
//             "sInfo": "Mostrando de START até END de TOTAL registros",
//             "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
//             "sInfoFiltered": "(Filtrados de MAX registros)",
//             "sInfoPostFix": "",
//             "sInfoThousands": ".",
//             "sLengthMenu": "MENU resultados por página",
//             "sLoadingRecords": "Carregando...",
//             "sProcessing": "Processando...",
//             "sZeroRecords": "Nenhum registro encontrado",
//             "sSearch": "Pesquisar",
//             "oPaginate": {
//                 "sNext": "Próximo",
//                 "sPrevious": "Anterior",
//                 "sFirst": "Primeiro",
//                 "sLast": "Último"
//             },
//             "oAria": {
//                 "sSortAscending": ": Ordenar colunas de forma ascendente",
//                 "sSortDescending": ": Ordenar colunas de forma descendente"
//             }
//         }
//     });
// });

</script>
 
<script>
    let selDiv = "";

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector('#arquivo').addEventListener('change', handleFileSelect);
        selDiv = document.querySelector("#arquivos_selecionados");
    });

    function handleFileSelect(e) {
        const files = e.target.files;
        if (!files || files.length === 0) return;

        let extensaoNaoPermitida = false;
        let excedeuLimiteTam = false;
        let mensagemValidacao = "";

        const allowedExtensionsRegx = /\.pdf$/i;
        const maxSize = 3145728; // 3MB

        for (let i = 0; i < files.length; i++) {
            const nomeArquivo = files[i].name;
            const tamanho = files[i].size;

            if (!allowedExtensionsRegx.test(nomeArquivo)) {
                extensaoNaoPermitida = true;
            }

            if (tamanho > maxSize) {
                excedeuLimiteTam = true;
            }
        }

        if (extensaoNaoPermitida) {
            mensagemValidacao += "São permitidos apenas arquivos em PDF!\n";
        }

        if (excedeuLimiteTam) {
            mensagemValidacao += "O limite de tamanho é 3MB para cada anexo!";
        }

        if (mensagemValidacao) {
            e.target.value = ""; // limpa o input
            selDiv.innerHTML = "";
            alert(mensagemValidacao);
            return;
        }

        // Exibição dos arquivos
        selDiv.innerHTML = "Você selecionou " + files.length + (files.length > 1 ? " arquivos:<br/>" : " arquivo:<br/>");

        for (let i = 0; i < files.length; i++) {
            const f = files[i];
            const tamanho = f.size;

            selDiv.innerHTML += `<i class="fa fa-file"></i> ${i + 1} - ${f.name} - `;

            if (tamanho >= 1048576) {
                selDiv.innerHTML += (tamanho / 1024 / 1024).toFixed(2).replace('.', ',') + " MB<br/>";
            } else {
                selDiv.innerHTML += (tamanho / 1024).toFixed(2).replace('.', ',') + " KB<br/>";
            }
        }
    }
</script>
@endsection
