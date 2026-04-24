<!DOCTYPE html>
@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')

<h5>AUDITORIA DE OPERAÇÕES</h5>
<div class="mb-3">

  <form action="{{route('Audits_filter')}}" method="POST">
      @csrf
      <div class="form-row">
      <div class="form-group col-md-2">
        <label>Pesquisa Tabela:</label>
        <input type="text" name="search" class="form-control">
      </div>
      <div class="form-group col-md-2">
        <label>Usuário:</label>
        <select type="user_id" name="user_id" class="form-control">
          <option value="">Selecione</option>
          @foreach($user as $u)
          <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group col-md-2">
        <label>Evento:</label>
        <select type="event" name="event" class="form-control">
          <option value="">Selecione</option>
          <option value="created">Criado</option>
          <option value="updated">Editado</option>
          <option value="deleted">Excluído</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label>ID da Auditoria:</label>
        <input type="text" name="id" class="form-control">
      </div>
      <div class="form-group col-md-2">
        <label>Dt.Criação Evento de:</label>
        <input type="date" name="data_inicial" class="form-control">
      </div>
      <div class="form-group col-md-2">
        <label>até:</label>
        <input type="date" name="data_final" class="form-control">
      </div>
      </div>
      <button type="submit" class="btn btn-outline-secondary btn-sm">Filtrar</button><br><br>
    
  </form>

  <table class="table table-striped nowrap" style="width:100%" id="exemplo">
      <thead align="left">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nome do Usuário</th>
          <th scope="col">Evento</th>
          <th scope="col">Data</th>
          <th scope="col">Tabela</th>
          <th scope="col">ID Auditoria</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @if(count($audits)==0)
          <td colspan="5">Não há Auditoria cadastrada no momento e/ou que atenda os filtros selecionados! Clique no botão "para Sair"</td>
      @else
          @foreach ($audits as $audit)
          <tr>
            <td>{{$audit->id}}</td>
            <td>{{App\User::whereId($audit->user_id)->value('name')}}</td>
            <td>{{$audit->event}}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($audit->created_at)) }}</td>
            <td>{{$audit->auditable_type}}</td>
            <td>{{$audit->auditable_id}}</td>
            <td> 
              <a href="{{route('Audits_show',$audit->id)}}" class="btn btn-outline-secondary btn-sm"> + Detalhes </a>
            </td>
          </tr>  
          @endforeach
      @endif
      </tbody>
  </table>
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