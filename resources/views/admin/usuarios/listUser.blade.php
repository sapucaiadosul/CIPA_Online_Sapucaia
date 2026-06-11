@extends('admin.layouts.master')
@section('title','Exemplo')
@section('content')
<style>
    .usuarios-table {
        width: 100% !important;
    }

    .usuarios-table .col-texto-longo {
        max-width: 280px;
        white-space: normal;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .usuarios-table .col-email {
        max-width: 320px;
    }

    .usuarios-table .col-acoes {
        min-width: 210px;
        white-space: nowrap;
    }

    .usuarios-table .form-status {
        display: inline-block;
        margin-bottom: 0;
    }
</style>

@if(session('CadastrarUsuario'))
    <script>
	Swal.fire({
	   icon: 'success',
	   title: 'Dados cadastrados com sucesso!',
	   showConfirmButton: false,
	   timer: 3000
	})
	</script>	
@endif
@if(session('EditarUsuario'))
    <script>
	Swal.fire({
	   icon: 'success',
	   title: 'Dados alterados com sucesso!',
	   showConfirmButton: false,
	   timer: 3000
	})
	</script>	
@endif
@if(session('ExcluirUsuario'))
    <script>
	Swal.fire({
	   icon: 'success',
	   title: 'Exclusão realizada com sucesso!',
	   showConfirmButton: false,
	   timer: 3000
	})
	</script>	
@endif
<div class="card">
    <div class="card-header">
        <h5 class="col-12 modal-title text-left">MANUTENÇÃO DE USUÁRIOS DO SISTEMA</h5>
     
    </div>
    <h6 class="col-12 modal-title text-center"></h6>
    <div class="container col-md-12">
        <div class="container-fluid no-padding table-responsive">
            <table class="table table-striped table-sm usuarios-table" id="exemplo">
                <thead align="center">
                    <tr>
                        <th>Nº Registro</th>
                        <th>Nome Usuário(a)</th>
                        <th>E-mail</th>
                        <th>Nível</th>
                        <th>Habilitado</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @foreach ($user as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td class="col-texto-longo" title="{{$user->name}}">{{$user->name}}</td>
                        <td class="col-texto-longo col-email" title="{{$user->email}}">{{$user->email}}</td>
                        <td>
                        @switch($user->nivel)
                            @case('1')
                                Operador(a)
                            @break
                            @case('2')
                                Adm.Sistemas
                            @break
                            @case('3')
                                Adm.de TI
                            @break
                            @default
                                Operador(a)
                        @endswitch
                        </td>
                       
                        <td style="color: {{ $user->ativo ? 'green' : 'gray' }}">{{ $user->ativo ? 'Ativo' : 'Inativo' }}</td>
                        <td class="col-acoes">
                            <form action="{{ route('users.update', $user->id) }}" method="POST" class="form-status">
                                @csrf
                                @method('PUT')
                                @if ($user->ativo)
                                    <button type="submit" name="ativo" value="0" class="btn btn-secondary btn-sm">Inativar</button>
                                @else
                                    <button type="submit" name="ativo" value="1" class="btn btn-success btn-sm">Ativar</button>
                                @endif
                            </form>
                        </td>
                        <td class="col-acoes">
                            <a href="{{route('Usuarios_editar',$user->id)}}" class="btn btn-outline-secondary btn-sm"> Editar </a>
                            <form method="POST" action="{{route('Usuarios_destroy',$user->id)}}" style="display: inline" onsubmit="return confirm('Deseja realmente Excluir este Usuário?');" >
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
        responsive: false,
        scrollX: true,
        autoWidth: false,
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
