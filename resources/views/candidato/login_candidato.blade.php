@extends('layouts.header')
@section('content')

@if(session('NaoConectouBanco'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Não foi possível conectar ao Banco de Dados! Entre em contato com o Suporte de Informática.',
        showConfirmButton: false,
        showCloseButton: true,
    })
</script>
@endif
@if(session('JaTemCadastro'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Matrícula/CPF Já Inscritos para a CIPA!',
        showConfirmButton: false,
        showCloseButton: true,
    })
</script>
@endif
@if(session('NaoAchou'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Matrícula/CPF NÃO localizados no RH!',
        showConfirmButton: false,
        showCloseButton: true,
    })
</script>
@endif
@if(session('SemData'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Você está fora do período de Inscrição!',
        showConfirmButton: false,
        showCloseButton: true,
    })
</script>
@endif
@if(session('VinculoNaoPermitido'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Conforme legislação vigente esta matrícula não está autorizada para cadastro.',
        showConfirmButton: false,
        showCloseButton: true,
    })
</script>
@endif
@if(session('SemEstabilidade'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Conforme Decreto 5541/2008 e seus posteriores o vínculo desta Matrícula não permite inscrição.',
        showConfirmButton: false,
        showCloseButton: true,
    })
</script>
@endif

<body style="background-color: rgb(244, 244, 244)">
    <section class="gradient-form secao_login">
        <div class="container py-3 py-md-5 h-100" style="max-width: 100%">
            <div class="row d-flex justify-content-center align-items-center h-100 mx-0">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6 cpx-2 px-md-3">
                    <div class="card rounded-3 text-black" style="border-radius: .9rem;">
                        <div class="row g-0">
                            <div class="col-lg-4 d-none d-lg-flex align-items-center degrade_login">
                                <div class="w-100 text-center">
                                    <img src="{{asset('assets/img/cipa_logo_branco.png')}}" style="width:50%; margin:auto" alt="logo">
                                </div>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="card-body p-3 p-md-5 mx-md-4">
                                    <div class="text-center pb-3 pb-md-4">
                                        <img src="{{asset('assets/img/sistema_logo.png')}}" class="img-fluid" style="max-width:50%;margin: auto" alt="logo">
                                        <h5 class="mt-3" style="color: #818181;">Inscrição de candidato</h5>
                                    </div>
                                    <form action="{{ route('Candidato_Login') }}" method="post" class="form">
                                        @csrf
                                        @if (\Session::has('success'))
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                <li>{!! \Session::get('success') !!}</li>
                                            </ul>
                                        </div>
                                        @endif
                                        <div class="form-section">
                                            <label for="matricula">Matrícula (RH):</label>
                                            <input type="text" class="form-control mb-3" name="matricula" id="matricula" required="">
                                            <label for="datanasc">Data de nascimento:</label>
                                            <input type="date" class="form-control" name="datanasc" id="datanasc" required="">
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary botao" style="width:80%">
                                                Acessar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
@endsection