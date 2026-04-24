@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')
@include('flash::message')


    <div class="container-fluid" style="padding-top: 20px">
        <div class="position-relative">
            
            <div class="position-absolute" style="padding: 28px">
                <form method="GET">
                    <select
                        name="eleicao_id"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        @foreach ($eleicoes as $eleicao)
                            <option
                                value="{{ $eleicao->id }}"
                                {{ ($eleicaoId ?? null) == $eleicao->id ? 'selected' : '' }}
                            >
                                {{ $eleicao->descricao_eleicao }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body d-flex flex-wrap">
                            <div class="flex-fill d-flex align-items-center gap-2">
                                <i class="icon-people fs-4"></i>
                                <span>Total de votos: {{ $nr_votos }}</span>
                            </div>
                            <div class="flex-fill d-flex align-items-center gap-2">
                                <i class="icon-check fs-4"></i>
                                <span>Votos válidos: {{ $voto_valido }}</span>
                            </div>
                            <div class="flex-fill d-flex align-items-center gap-2">
                                <i class="icon-close fs-4"></i>
                                <span>Votos em branco: {{ $voto_branco }}</span>
                            </div>
                            <div class="flex-fill d-flex align-items-center gap-2">
                                <i class="icon-close fs-4"></i>
                                <span>Votos nulos: {{ $voto_nulo }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="container col-md-12">
            <div class="card">
                <div class="card-header bg-white border-bottom text-center">
                    <h5 class="mb-0 py-2">Lista de Candidatos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="exemplo">
                            <thead>
                                <tr class="text-center">
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>Apelido</th>
                                    <th>Matrícula</th>
                                    <th>Cargo/Função</th>
                                    <th>Total de Votos</th>
                                    <th>Situação</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($votacao_candidatos as $candidato)
                                <tr>
                                    <td>
                                        <img class="rounded-circle" 
                                            src="{{ asset('/storage/'. $candidato->foto)}}" 
                                            alt="Foto de {{$candidato->nome}}"
                                            style="margin-top: 5px; margin-bottom: 5px; width: 100px; height: 100px; object-fit: cover;">
                                    </td>
                                    <td>{{$candidato->nome}}</td>
                                    <td>{{$candidato->apelido}}</td>
                                    <td>{{$candidato->matricula}}</td>
                                    <td>{{$candidato->cargo_funcao}}</td>
                                    <td>{{$candidato->qtd_voto_candidato}}</td>
                                    <td>
                                        @if ($candidato->qtd_voto_candidato > 0)
                                            @if($loop->iteration <= 6)
                                                Titular
                                            @elseif($loop->iteration > 6 && $loop->iteration <= 11)
                                                Suplente
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Nenhum voto válido foi encontrado para esta eleição.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div>
        
@endsection
