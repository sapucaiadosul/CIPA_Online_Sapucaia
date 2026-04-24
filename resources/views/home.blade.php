@extends('layouts.header')
@section('title','CIPA Online')
@section('content')
@if (session('NaoVeResultados'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erro...',
        text: 'Os resultados da eleição ainda não estão disponiveis!'
    })
</script>
@endif

<div class="conteudo">
    <div class="container" style="max-width: 900px;">
        <div class="row justify-content-center g-3">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card text-center shadow bg-white rounded h-100" style="max-width: 310px; margin: 0 auto;">
                    <img class="card-img-top p-3" src="{{url('assets/img/candidato.png')}}" alt="">
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title mb-2">Candidato</h5>
                        <p class="card-text flex-grow-1"></p>
                        <a href="{{ route('Candidato_Index') }}"
                            class="btn btn-outline-secondary btn-sm stretched-link">Inscrição de Candidato</a>
                    </div>
                </div>
            </div>
            <div class="col-10 col-sm-6 col-md-4">
                <div class="card text-center shadow bg-white rounded h-100" style="max-width: 310px; margin: 0 auto;">
                    <img class="card-img-top p-3" src="{{url('assets/img/votacao.png')}}" alt="">
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title mb-2">Votação CIPA</h5>
                        <p class="card-text flex-grow-1"></p>
                        <a href="{{ route('Votacao_Index') }}"
                            class="btn btn-outline-secondary btn-sm stretched-link">Votação</a>
                    </div>
                </div>
            </div>
            <div class="col-10 col-sm-6 col-md-4">
                <div class="card text-center shadow bg-white rounded h-100" style="max-width: 310px; margin: 0 auto;">
                    <img class="card-img-top p-3" src="{{url('assets/img/administracao.png')}}" alt="">
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title mb-2">Comissão Eleitoral</h5>
                        <p class="card-text flex-grow-1"></p>
                        <a href="{{ route('Eleicoes_Create') }}"
                            class="btn btn-outline-secondary btn-sm stretched-link">Dados de Eleições</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection