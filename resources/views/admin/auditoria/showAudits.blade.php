@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')
    <div class="conteudo">
        <style>
            .btn-secondary:hover {
                color: #fff;
                background-color: #5a6268 !important;
                border-color: #545b62 !important
            }
        </style>
        <div class="card">
            <div class="card-header">
                <h4 class="col-12 modal-title text-center">DETALHES - Consulta da Auditoria de Operações</h5>
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
				<div class="form-group col-md-12">
					<div class="input-group">
						<label for="old_values" class="control-label">Informações Antigas:</label>
						<div class="input-group">
						<input type="text" class="form-control" id="old_values" name="old_values"
							value="{{ $audit->old_values }}" disabled>
						</div>
					</div>
				</div>
				<div class="form-group col-md-12">
					<div class="input-group">
						<label for="new_values" class="control-label">Informações Novas:</label>
						<div class="input-group">
						<textarea class="form-control z-depth-1" rows="6" class="form-control" id="new_values" name="new_values"
						disabled>{{ $audit->new_values }}</textarea>
					</div>
					</div>
				</div>
				<div class="form-group col-md-12">
					<div class="input-group">
						<label for="url" class="control-label">URL:</label>
						<div class="input-group">
						<input type="text" class="form-control" id="url" name="url"
							value="{{ $audit->url }}" disabled>
					</div>
					</div>
				</div>
				<div class="form-group col-md-12">
					<div class="input-group">
						<label for="$audit->ip_address" class="control-label">Endereço IP:</label>
						<div class="input-group">
						<input type="text" class="form-control" id="$audit->ip_address" name="$audit->ip_address"
							value="{{ $audit->ip_address }}" disabled>
					</div>
					</div>
				</div>
				<div class="form-group col-md-12">
					<div class="input-group">
						<label for="$audit->user_agent" class="control-label">Navegador:</label>
						<div class="input-group">
						<input type="text" class="form-control" id="$audit->user_agent" name="$audit->user_agent"
							value="{{ $audit->user_agent }}" disabled>
					</div>
				</div>
				</div>
				<div class="form-group col-md-12">
					<div class="input-group">
						<label for="$audit->$audit->tags" class="control-label">Tags:</label>
						<div class="input-group">
						<input type="text" class="form-control" id="$audit->$audit->tags" name="$audit->$audit->tags"
							value="{{ $audit->tags }}" disabled>
						</div>
					</div>
				</div>
				<div class="form-group col-md-12">
					<div class="input-group">
						<label for="$audit->$audit->tags" class="control-label">Dt.Criação:</label>
						<div class="input-group">
						<input type="text" class="form-control" id="$audit->$audit->tags" name="$audit->$audit->tags"
							value="{{\Carbon\Carbon::parse($audit->created_at)->format('d/m/Y')}}" disabled>
					</div>
					</div>
				</div>
				<div class="form-group col-md-12">
					<div class="input-group">
						<label for="$audit->$audit->tags" class="control-label">Dt.Alteração:</label>
						<div class="input-group">
						<input type="text" class="form-control" id="$audit->$audit->tags" name="$audit->$audit->tags"
							value="{{\Carbon\Carbon::parse($audit->updated_at)->format('d/m/Y')}}" disabled>
					</div>
					</div>
				</div>
            </div>
            <div class="mb-3" style="padding-left: 20px">
                <a href="{{ route('Audits_listAll') }}" class="btn btn-outline-secondary btn-sm"> Voltar p/ Auditoria de Operações
                </a>
            </div>
        </div>
        </form>
    </div>
@endsection