<!DOCTYPE html>
@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')

<h5>AUDITORIA DE ACESSOS</h5>
<div class="mb-3">

  <form action="{{route('Access_filter')}}" method="POST">
      @csrf
      <div class="form-row">
      <div class="form-group col-md-2">
         <label>Pesquisa Usuário:</label>
          <select type="user_id" name="user_id" class="form-control">
          <option value="">Selecione</option>
          @foreach($user as $u)
          <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group col-md-2">
        <label>Tipo:</label>
        <input type="text" name="type" class="form-control">
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
          <th scope="col">Tipo</th>
          <th scope="col">Data</th>
          <th scope="col">ID</th>
          <th scope="col">Usuário</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @if(count($access)==0)
          <td colspan="5">Não há Auditoria cadastrada no momento e/ou que atenda os filtros selecionados! Clique no botão "para Sair"</td>
      @else
          @foreach ($access as $acessos)
          <tr>
            <td>{{$acessos->id}}</td>
            <td>{{$acessos->type}}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($acessos->created_at)) }}</td>
            <td>{{$acessos->id}}</td>
            <td>{{App\User::whereId($acessos->user_id)->value('name')}}</td>
           <td> 
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