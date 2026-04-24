@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')
@include('flash::message')

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

<div class="container">
    <div class="card">
        <div class="card-header">{{ __('EDITAR USUÁRIOS') }}</div>

            <form method="POST" action="{{ route('Usuarios_update') }}">
            @csrf
            <input type="hidden" value="{{$usuario->id}}" name="user_id">
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
            
                        <div class="input">
                            <label for="name" class="control-label">Nome de Usuário(a)</label>
                            <input id="name" type="text" required class="form-control @error('name') is-invalid @enderror" name="name" value="{{$usuario->name}}" autofocus placeholder="Nome do Usuário">
                
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
                            name="email" value="{{$usuario->email}}" autocomplete="email" autofocus placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="cpf" class="control-label">CPF: *</label>
                        <div class="input-group">
                            <input type="string" name="cpf" id="cpf" class="form-control cpf"
                            value="{{$usuario->cpf}}" maxlength="14" required>
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
                            name="password" value="{{$usuario->password}}" required autocomplete="current-password" placeholder="Senha">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="form-group  col-md-3">
                        <label for="Confirme a senha" class="control-label">Confirme a Senha</label>
                        <input id="password-confirm" type="password" required class="form-control @error('password') is-invalid @enderror" name="password_confirmation" value="{{$usuario->password}}
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
                        <label>Nível do Usuário</label>
                        <div class="input-group">
                             <select id="nivel" required="" name="nivel" class="form-control">
                                 <option value="">-- Selecione o Nível --</option>
                                 <option {{ ($usuario->nivel) == '1' ? 'selected' : '' }}  value="1">Operador</option>
                                 <option {{ ($usuario->nivel) == '2' ? 'selected' : '' }}  value="2">Adm.Sistema</option>
                                 <option {{ ($usuario->nivel) == '3' ? 'selected' : '' }}  value="3">Adm.de TI</option>
                            </select>
                        </div>
                    </div>
                    <br><br><br><br><br>

                </div> 
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Salvar</button>
                    <a href="{{route('Usuarios_listUser')}}" type="button" class="btn btn-outline-secondary btn-sm">Voltar p/ Manutenção de Usuários</a>
                </div>
         
        </form>
    </div>

    <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/vendor/jquery/jquery-mask/jquery.mask.min.js') }}"></script>
    <script>
        $('#cpf').mask('999.999.999-99');
    </script>   
</div>

@endsection