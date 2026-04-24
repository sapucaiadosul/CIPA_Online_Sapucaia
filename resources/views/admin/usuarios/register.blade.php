@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>REGISTRAR USUÁRIOS NO SISTEMA</h5>
        </div>
        <div class="form-group col-md-12">
            @if($errors->all())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
        <div class="container col-12">
            <div class="form-row">
                <div class="form-group  col-md-3">
                    <form method="POST" action="{{ route('Usuarios_registerstore') }}">
                        @csrf
                        <div class="input">
                            <label for="name" class="control-label">Nome de Usuário(a)</label>
                            <input id="name" type="text" required class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Nome">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                </div>

                <div class="form-group  col-md-3">
                    <label for="email" class="control-label">E-mail</label>
                    <input id="email" type="email" required class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="cpf" class="control-label">CPF: *</label>
                    <div class="input-group">
                        <input type="string" name="cpf" id="cpf" class="form-control cpf" placeholder="000.000.000-00"
                        value="{{old('cpf')}}" maxlength="14" required>
                        @error('cpf')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group  col-md-3">
                    <label for="senha" class="control-label">Senha</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" value="{{ old('password') }}" required autocomplete="current-password" placeholder="Senha">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group  col-md-3">
                    <label for="Confirme a senha" class="control-label">Confirme a Senha</label>
                    <input id="password-confirm" type="password" required class="form-control @error('password') is-invalid @enderror" name="password_confirmation"
                        autocomplete="new-password" placeholder="Confirmar senha">

                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                 
                <div class="form-group  col-md-3">
                    <label for="nivel" class="control-label">Nível de Acesso</label>
                    <div class="input-group">
                        <select required id="nivel" name="nivel" class="form-control">
                            <option value="1">{{__('Operador(a)')}}</option>
                            <option value="2">{{__('Adm.Sistema')}}</option>
                            <option value="3">{{__('Adm.de TI')}}</option>
                        </select>
                    </div>
                </div>
                <br><br><br><br><br>
                </div>
              
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/vendor/jquery/jquery-mask/jquery.mask.min.js') }}"></script>
    <script>
        $('#cpf').mask('999.999.999-99');
    </script>   
</div>
</div>
@endsection
