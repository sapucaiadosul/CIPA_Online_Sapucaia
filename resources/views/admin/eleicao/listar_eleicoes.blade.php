@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')
@include('flash::message')
@if(session('CadastrarEleicao'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Dados da Eleição Cadastrados com Sucesso!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('EditarEleicoes'))
    <script>
	Swal.fire({
	   icon: 'success',
	   title: 'Dados Alterados com Sucesso!',
	   showConfirmButton: false,
	   timer: 3000
	})
	</script>	
@endif
@if(session('ExcluirEleicoes'))
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
        <h5 class="col-12 modal-title text-left">LISTA/MANUTENÇÃO DE DADOS DA ELEIÇÃO</h5>
     
    </div>
    <h6 class="col-12 modal-title text-center"></h6>
    <div class="container col-md-12">
        <div class="container-fluid no-padding table-responsive-sm">
            <table class="table table-striped nowrap" style="width:100%" id="exemplo">
                <thead align="center">
                    <tr>
                        <th>Nº ID Eleição</th>
                        <th>Descrição Eleição</th>
                        <th>Número Indicados</th>
                        <th>Número Inscritos</th>
                        <th>Número Eleitos</th>

                    </tr>
                </thead>
                <tbody align="center">
                    @foreach ($eleicoes as $param)
                    <tr>
                        <td>{{$param->id}}</td>
                        <td>{{$param->descricao_eleicao}}</td>
                        <td>{{$param->numero_indicados}}</td>
                        <td>{{$param->numero_nao_indicados}}</td>
                        <td>{{$param->numero_eleitos}}</td>
                    <td>
                        <a href="{{route('Eleicoes_Edit',$param->id)}}" class="btn btn-outline-secondary btn-sm"> Ver </a>
                        <form method="POST" action="{{route('Eleicoes_Destroy',$param->id)}}" style="display: inline" onsubmit="return confirm('Deseja realmente Excluir esta Eleição?');" >
                            @csrf
                            @method("GET")
                            <button class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i> Excluir </button>
                        </form>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    $('#exemplo').DataTable({
        select: false,
        responsive: true,
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
