@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')
@include('flash::message')

@if(session('EditarCandidato'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Dados Alterados com Sucesso!',
        showConfirmButton: false,
        timer: 3000
    })
</script>
@endif
@if(session('ExcluirCandidato'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Exclusão Realizada com Sucesso!',
        showConfirmButton: false,
        timer: 3000
    })
</script>
@endif
<div class="card">
    <div class="card-header">
        <h5 class="col-12 modal-title text-left">LISTA/MANUTENÇÃO DE CANDIDATOS</h5>
    </div>

    <div class="container col-md-12 my-2">
        <!-- Filtro por eleição -->
        <form method="GET" action="{{ route('Candidato_Listar') }}">
            <div class="form-group row">
                <label for="eleicao_id" class="col-md-2 col-form-label">Eleição Comissão CIPA:</label>
                <div class="col-md-4">
                    <select name="eleicao_id" id="eleicao_id" class="form-control" onchange="this.form.submit()">
                        @foreach ($eleicoes as $eleicao)
                        <option value="{{ $eleicao->id }}" {{ $eleicao->id == $eleicaoId ? 'selected' : '' }}>
                            {{ $eleicao->descricao_eleicao }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    <h6 class="col-12 modal-title text-center"></h6>
    <div class="container col-md-12">
        <div class="container-fluid no-padding table-responsive">
            <table class="table table-striped table-sm nowrap" id="exemplo">
                <thead align="center">
                    <tr>
                        <th>Nº Inscrição</th>
                        <th>Matrícula</th>
                        <th>Nome Completo</th>
                        <th>Cargo/Função</th>
                        <th>Eleição</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @foreach ($candidatos as $candidato)
                    <tr>
                        <td>{{$candidato->id}}</td>
                        <td>{{$candidato->matricula}}</td>
                        <td>{{$candidato->nome}}</td>
                        <td>{{$candidato->cargo_funcao}}</td>
                        <td>{{$candidato->Eleicoes->descricao_eleicao ?? '-'}}
                        <td>
                            @if ($candidato->status == '0')
                            Pendente
                            @else Homologado
                            @endif
                        </td>
                        <td>
                            <a href="{{route('Candidato_Edit',$candidato->id)}}" class="btn btn-outline-secondary btn-sm"> Editar </a>
                            <form method="POST" action="{{route('Candidato_Destroy',$candidato->id)}}" style="display: inline" onsubmit="return confirm('Deseja realmente Excluir este Candidato?');">
                                @csrf
                                @method("GET")
                                <button class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i> Excluir </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $candidatos->links() }}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#exemplo').DataTable({
            select: false,
            responsive: true,
            autoWidth: false,
            scrollX: true,
            "order": [
                [0, "asc"]
            ],
            "info": false,
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
                "sSearch": "Pesquisar",
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
</script>
@endsection