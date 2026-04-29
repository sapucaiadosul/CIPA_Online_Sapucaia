@extends('admin.layouts.master')
@section('title','Servidores')
@section('content')
@include('flash::message')

@if(session('EditarServidor'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Dados alterados com sucesso!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>
@endif

<div class="card">
    <div class="card-header">
        <h4 class="col-12 modal-title text-center">MANUTENÇÃO DE SERVIDOR</h4>
    </div>

    <form method="POST" action="{{ route('Servidor_Update', $servidor->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $servidor->id }}" name="servidor_id">

        <div class="form-group col-md-12">
            @if($errors->all())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>

        <div class="form-row">
            <div class="container col-md-12">
                <div class="form-group col-md-12">
                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="matricula" class="control-label">Matrícula:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="matricula" name="matricula"
                                    placeholder="Matrícula" value="{{ old('matricula', $servidor->matricula) }}">
                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="nome" class="control-label">Nome completo:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nome" name="nome"
                                    placeholder="Nome Completo" value="{{ old('nome', $servidor->nome) }}">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="cpf" class="control-label">CPF:</label>
                            <div class="input-group">
                                <input type="text" class="form-control cpf" id="cpf" name="cpf"
                                    placeholder="000.000.000-00" value="{{ old('cpf', $servidor->cpf) }}">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="dt_nascimento" class="control-label">Data de nascimento:</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento"
                                    placeholder="Data de Nascimento" value="{{ old('dt_nascimento', \Carbon\Carbon::parse($servidor->dt_nascimento)->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="vinculo" class="control-label">Vínculo:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="vinculo" name="vinculo"
                                    placeholder="Vínculo" value="{{ old('vinculo', $servidor->vinculo) }}">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Salvar</button>
                    <a href="{{ route('Servidor_Listar') }}" type="button" class="btn btn-outline-secondary btn-sm">Voltar p/ Lista de Servidores</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/vendor/jquery/jquery-mask/jquery.mask.min.js') }}"></script>

<script>
    $('.cpf').mask('999.999.999-99');
</script>
@endsection