@extends('admin.layouts.master')
@section('title','Exemplo')
@section('content')
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
        <div class="container-fluid no-padding table-responsive-sm">
            <table class="table table-striped nowrap" style="width:100%" id="exemplo">
                <thead align="center">
                    <tr>
                        <th>Nº Registro</th>
                        <th>Nome Usuário(a)</th>
                        <th>E-mail</th>
                        <th>Nível</th>
                        <th>Habilitado</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @foreach ($user as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
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
                        <td>
                            <td>
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @if ($user->ativo)
                                    <button type="submit" name="ativo" value="0" class="btn btn-secondary">Inativar</button>
                                @else
                                    <button type="submit" name="ativo" value="1" class="btn btn-success">Ativar</button>
                                @endif
                            </form>
                            <td>
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
