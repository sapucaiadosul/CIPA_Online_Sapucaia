@extends('layouts.master')
@section('title','CIPA OnLine')
@section('content')
    <div class="conteudo">
        <style>
            .btn-secondary:hover {
                color: #fff;
                background-color: #5a6268 !important;
                border-color: #545b62 !important;
            }
        </style>
        <div class="card">
            <div class="card-header">
                <h4 class="col-12 modal-title text-center">DETALHES - Consulta Dados da Eleição</h5>
            </div>
            @if ($errors->all())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <h6 class="col-12 modal-title text-center"></h6>
            <div class="container col-12">
                <div class="form-row">

                </div>
            </div>


        </div>   
@endsection