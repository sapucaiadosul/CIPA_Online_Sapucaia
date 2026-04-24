@extends('layouts.header')
@section('title','CIPA Online')
@section('content')

<div style="width:35%;margin:auto;padding-top:100px">
  @csrf
  
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-center" style="background: linear-gradient(to right, rgb(67, 206, 162), #1abc9c);padding:40px">
        <span style="color:white">
        <i class="fa-regular fa-circle-check fa-6x"></i>
        </span>
        </div>
        <div style="padding: 25px;text-align: center;">
        <p>Clique <a href="{{ route('Candidato_pdfVotacao',['id' => $candidato_id])}}"> aqui</a> para gerar o Comprovante da Votação.</p>
        </div>
    </div>
<div>
@endsection