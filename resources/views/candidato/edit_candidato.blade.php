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

<div class="card">
    <div class="card-header">
        <h4 class="col-12 modal-title text-center">MANUTENÇÃO DE CANDIDATO</h4>
    </div>
    
    <form method="POST" action="{{ route('Candidato_Update') }}"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{$candidato->id}}" name="candidato_id">
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
                    <div class="col-md-10">
                            <div class="form-group row">
                                <label for="eleicoes_id" class="col-md-4 label-control">Eleição Comissão CIPA:</label>
                                <div class="col-md-8">
                                    <select name="eleicoes_id" class="form-control" id="eleicoes_id">
                                        @foreach ($eleicoes as $param)
                                            <option  {{ $candidato->eleicoes_id == $param->id ? 'selected' : '' }}
                                                value="{{ $param->id }}">{{ $param->descricao_eleicao }}</option>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        

                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="matricula" class="control-label">Matrícula:</label>
                            <div class="input-group">
                                <input type="matricula" class="form-control" id required="matricula" name="matricula" readonly
                                placeholder="Matrícula" value="{{ $candidato->matricula }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nome" class="control-label">Nome Completo:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nome" name="nome" readonly
                                    placeholder="Nome Completo" value="{{ $candidato->nome }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nome" class="control-label">Apelido:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="apelido" name="apelido"
                                    placeholder="Apelido" value="{{ $candidato->apelido }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="email" class="control-label">E-mail:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="E-mail" value="{{ $candidato->email }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="telefone" class="control-label">Telefone/Celular:</label>
                            <div class="input-group">
                                <input type="text" class="form-control celular" id="telefone" name="telefone"
                                    placeholder="Telefone" value="{{ $candidato->telefone }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="dt_nascimento" class="control-label">Data de Nascimento:</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="telefone" name="dt_nascimento" readonly
                                    placeholder="Data de Nascimento" value="{{ $candidato->dt_nascimento }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="lotacao" class="control-label">Lotação:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="lotacao" name="lotacao" readonly
                                    placeholder="Lotação" value="{{ $candidato->lotacao }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="lotacao" class="control-label">Cargo/Função:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="cargo_funcao" name="cargo_funcao" readonly
                                    placeholder="Cargo/Função" value="{{ $candidato->cargo_funcao }}">
                            </div>
                        </div>
                                    
                        <div class="form-group col-md-3">
                            <label for="cpf" class="control-label">CPF</label>
                            <div class="input-group">
                                <input type="string" class="form-control" id="cpf" name="cpf" readonly
                                    placeholder="000.000.000-00" value="{{ $candidato->cpf }}">
                            </div>
                        </div>
                        <div class="form-group  col-md-3">
                            <label>Status</label>
                            <div class="input-group">
                                <select id="status" required="" name="status" class="form-control">
                                    <option {{ ($candidato->status) == '0' ? 'selected' : '' }}  value="0">Pendente</option>
                                    <option {{ ($candidato->status) == '1' ? 'selected' : '' }}  value="1">Homologado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Histórico/Biografia:</label>
                            <div class="form-group shadow-textarea">
                            <textarea name='historico' class="form-control z-depth-1" id="comentario" rows="3"
                                >{{ isset($candidato->historico) ? $candidato->historico : old('historico') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                        <div class="form-group col-md-5">
                            <label for="anexo" class="control-label">Foto:</label>
                            <div class="input-group">
                            <button type="button" id="btnAlterarFoto" class="btn btn-outline-secondary btn-sm" onclick="alterarFoto()" hidden>Alterar Foto</button>
                            <input type="file" id="foto" name="foto" hidden>
                                <img id="previa_foto_candidato" style="max-height: 250px;"
                                src="{{ asset('storage/'. $candidato->foto) }}">
                            </div>
                        </div>    
                    </div>
                </div>    
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-secondary btn-sm">Salvar</button>
                <a href="{{route('Candidato_Listar')}}" type="button" class="btn btn-outline-secondary btn-sm">Voltar p/ Lista de Candidatos</a>
            </div>
        </form>
    </div>    
</div>

<script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/vendor/jquery/jquery-mask/jquery.mask.min.js') }}"></script>

<script>
    $('#cpf').mask('999.999.999-99');
    $('.celular').mask('(00) 00000-0000');
    $('.telefone').mask('(00) 0000-0000');
    $('.dinheiro').mask('00.000,00', { reverse: false });
    $('.numero').mask('00000', { reverse: false });
</script> 

<script type="text/javascript">
function alterarFoto(){
        $('#foto').attr('hidden', false);
    }

    $(document).ready(function (e) {
    var possuiFoto=false;
    if ("{{ $candidato->foto }}"){
        possuiFoto=true;
        $('#foto').attr('hidden', true);
        $('#btnAlterarFoto').attr('hidden', false);
    }
    $('#foto').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#previa_foto_candidato').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
});            

</script>
@endsection
