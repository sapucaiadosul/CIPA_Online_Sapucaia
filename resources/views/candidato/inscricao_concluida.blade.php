@extends('layouts.header')
@section('title','CIPA Online')
@section('content')

<div class="container py-5" style="max-width: 100%;">
  <div class="row justify-content-center">
    <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
      @csrf

      <div class="card" style="border-radius: 15px;">
        <div class="card-header d-flex align-items-center justify-content-center" style="background: linear-gradient(to right, rgb(67, 206, 162), #1abc9c);padding:40px;border-top-left-radius: 15px;border-top-right-radius: 15px;">
          <span style="color:white">
            <i class="fa-regular fa-circle-check fa-4x fa-md-5x fa-lg-6x"></i>
          </span>
        </div>
        <div class="card-body p-4 text-center" style="color: #7c7c7c;">
          <p class="mb-3"><strong>Inscrição concluída com sucesso!</strong></p>
          <p class="mb-4">Clique no botão abaixo para gerar o comprovante.</p>
          <a class="btn btn-primary botao w-100" href="{{ route('Candidato_pdfInscricao',['id' => $candidato_id])}}" target="_blank" rel="noopener noreferrer" style="background: #e57373!important;border: 0px;max-width: 300px;">Gerar comprovante</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
