@extends('layouts.header')
@section('content')
@if (session('NaoVota'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erro...',
        text: 'Votação fora do Período Permitido!'
    })
</script>
@endif

@if (session('JaVotou'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erro...',
        text: 'Já existe voto registrado na eleição para esta matrícula!'
    })
</script>
@endif


@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erro...',
        text: 'Matrícula e/ou CPF não Encontrados!'
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
                            <div class="col-lg-5 d-none d-lg-flex align-items-center degrade_login">
                                <div class="w-100 text-center">
                                    <img src="{{asset('assets/img/cipa_logo_branco.png')}}"
                                        style="width:50%; margin:auto" alt="logo">
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="card-body p-3 p-md-5 mx-md-4">
                                    <div class="text-center pb-3 pb-md-4">
                                        <img src="{{asset('assets/img/sistema_logo.png')}}"
                                            style="max-width:50%; margin:auto" alt="logo">
                                        <h5 style="color: #818181;">Votação</h5>
                                    </div>
                                    <form action="{{ route('Votacao_Login') }}" method="post" class="form">
                                        @csrf
                                        @if (\Session::has('success'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                <li>{!! \Session::get('success') !!}</li>
                                            </ul>
                                        </div>
                                        @endif
                                        <div class="form-section">
                                            <label for="user">Matrícula (RH):</label>
                                            <input type="text" class="form-control mb-3" name="matricula" id="matricula" required="">
                                            <label for="registration">CPF:</label>
                                            <input type="text" class="form-control" name="cpf" id="cpf" required="">
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
<script>
    $('#cpf').mask('999.999.999-99');
</script>
@endsection