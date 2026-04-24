@extends('admin.layouts.master')
@section('title', 'CIPA_Online')
@section('content')
<h3 class="col-12 modal-title text-center">LISTAGEM GERAL DE CANDIDATOS</h3>
<div class="mb-3">
    <form action="{{ route('Candidato_FilterCandidato') }}" method="POST">
        @csrf
        <div class="card">
            <div class="container col-md-12">
                <div class="card-header">
                    <label class="col-12 modal-title text-center"> Filtre os campos abaixo conforme sua necessidade</label><br />
                    <div class="form-group">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label for="eleicoes_id" class="col-md-5 label-control">Eleições CIPA:</label>
                                <div class="col-md-7">
                                    <select name="eleicoes_id" class="form-control" id="eleicoes_id">
                                        @foreach ($eleicoes as $eleicao)
                                        <option value="{{ $eleicao->id }}"
                                            @if (old('id')==$eleicao->eleicoes_id) {{ 'selected' }} @endif>
                                            {{ $eleicao->descricao_eleicao }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group row">
                                <label for="id_candidato" class="col-md-5 label-control">Nome do Candidato:</label>
                                <div class="col-md-7">
                                    <select name="id" class="form-control" id="id">
                                        <option value="">Nome do Candidato</option>
                                        @foreach ($candidatos as $candidato)
                                        <option value="{{ $candidato->id }}"
                                            @if (old('id')==$candidato->id) {{ 'selected' }} @endif>
                                            {{ $candidato->nome }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group row">
                                <label for="cpf" class="col-md-5 label-control">CPF:</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="cpf" name="cpf"
                                        placeholder="000.000.000-00">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-row">
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Filtrar Dados / Limpar </button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="mostrarTelaCarregando()"
                                    id="btnGerarRelatorio">Gerar Listagem de Candidatos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="card">
        <table class="table table-striped nowrap" style="width:100%" id="filterListagemCandidato">
            <thead align="left">
                <tr>
                    <th scope="col">Eleições CIPA</th>
                    <th scope="col">Nº de Inscrição</th>
                    <th scope="col">Data de Inscrição</th>
                    <th scope="col">Matrícula</th>
                    <th scope="col">Nome do Candidato</th>
                    <th scope="col">Situação</th>
                    <th scope="col">CPF</th>

                </tr>
            </thead>
            <tbody>
                @if (count($candidatos) == 0)
                <td colspan="5">Não há Candidato cadastrado no momento e/ou que atenda os filtros selecionados!</td>
                @else
                @foreach ($candidatos as $candidato)
                <tr>
                    <td>{{ $candidato->Eleicoes->descricao_eleicao }}</td>
                    <td>{{ $candidato->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($candidato->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $candidato->matricula }}</td>
                    <td>{{ $candidato->nome }}</td>
                    <td>
                        @if ($candidato->status == '0')
                        Pendente
                        @else Homologado
                        @endif
                    </td>
                    @if ($candidato->cpf != null)
                    <td>{{ substr($candidato->cpf, 0, 3) . '.' . substr($candidato->cpf, 3, 3) . '.' . substr($candidato->cpf, 6, 3) . '-' . substr($candidato->cpf, 9, 2) }}
                    </td>
                    @else
                    <td>{{ 'CPF Não informado' }}</td>
                    @endif
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
    $('#cpf').mask('999.999.999-99');
</script>
<script>
    $(document).ready(function() {
        $('#filterListagemCandidato').DataTable({
            select: false,
            responsive: true,
            rowId: 'Id',
            "order": [
                [0, "asc"]
            ],
            columns: [{
                    data: "eleicao"
                },
                {
                    data: "inscricao"
                },
                {
                    data: "data_inscricao"
                },
                {
                    data: "matricula"
                },
                {
                    data: "nome"
                },
                {
                    data: "apelido"
                },
                {
                    data: "cpf"
                }

            ],
            "info": false,
            "searching": false,
            "sLengthMenu": false,
            "bLengthChange": false,
            "oLanguage": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de START até END de TOTAL registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de MAX registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "MENU resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": " ",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }

        });
    });

    $(document).ready(function() {
        $('#btnGerarRelatorio').click(function(e) {
            e.preventDefault();
            var table = $('#filterListagemCandidato').DataTable();
            var allData = table.rows().data().toArray();
            console.log(allData);
            var candidato_ids = [];
            var eleicao_id = $('#eleicoes_id').val();
            allData.forEach(userObj => {
                candidato_ids.push(userObj.inscricao);
            });

            $.ajax({
                type: 'GET',
                url: '/candidato/pdf_listagem_geral',
                xhrFields: {
                    responseType: 'blob'
                },
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    listagem_candidatos: candidato_ids,
                    eleicao_id: eleicao_id
                },
            }).done(function(data) {
                var blob = new Blob([data]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Listagem_Candidatos.pdf";
                link.click();
                ocultarTelaCarregando();
            }).fail(function(data) {
                ocultarTelaCarregando();
            });
        });
    });
</script>
@endsection