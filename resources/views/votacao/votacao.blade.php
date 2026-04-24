@extends('layouts.header')
@section('content')
@if(session('CadastrarVoto'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Votação Realizada com Sucesso!',
        showConfirmButton: false,
        timer: 3000
    })
</script>

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@endif

<input type="hidden" name="id" id="id">
<div class="container-fluid px-2 px-lg-3">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <div class="card">
                <div id="area_votacao">
                    <div class="card-header text-center text-white py-3 mb-0" style="background: linear-gradient(to right, rgb(67, 206, 162), #1abc9c);">
                        <h4 class="mb-0">VOTAÇÃO CIPA</h4>
                    </div>
                    
                    <div class="p-2 p-md-3">
                        <div class="row g-3">
                    @foreach($candidatos as $candidato)
                    <div class="col-12">
                        <div class="card border-0 border-bottom shadow-none">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-auto text-center">
                                        <img class="img-fluid rounded" style="max-width: 80px;" src="{{asset('/storage') . '/' . $candidato->foto}}" alt="Foto candidato">
                                    </div>
                                    <div class="col">
                                        <div class="mb-2"><strong>Nome:</strong> {{ $candidato->nome }}</div>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-2"><strong>Matrícula:</strong> {{ $candidato->matricula}}</div>
                                            <div class="col-12 col-sm-6 mb-2"><strong>Apelido:</strong> {{ $candidato->apelido }}</div>
                                        </div>
                                        <div class="mb-2"><strong>Cargo:</strong> {{ $candidato->cargo_funcao }}</div>
                                        <div class="mb-3"><strong>Lotação:</strong> {{ $candidato->lotacao }}</div>
                                    </div>
                                </div>
                                <div class="d-grid justify-content-center" style="width:100%">
                                            <a href="javascript:void(0)" data-toggle="tooltip" onClick="confirmarVotacao('{{ $candidato->id }}', '{{ $candidato->nome }}')" data-original-title="Votar" class="btn btn-primary botao" id="votar">Votar</a>
                                        </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row g-3 p-2">
                    <div class="col-12 col-md-6">
                        <button type="submit" class="btn btn-secondary botao botao_branco w-100" id="branco">
                            <i class="fa-regular fa-file me-2"></i>Votar em Branco
                        </button>
                    </div>
                    <div class="col-12 col-md-6">
                        <button type="submit" class="btn btn-secondary botao botao_nulo w-100" id="votos_nulo">
                            <i class="fa-solid fa-xmark me-2"></i>Votar Nulo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css" />
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

<script>
    tabelaVotacao();

    function apresentarConfirmacao(id_votacao) {

        var rota = '{{ route('Votacao_Comprovante',['id_votacao' => ":id_votacao" ])}}';
        var rota_final = rota.replace(':id_votacao', id_votacao);

        var confirmacao = '<div class="card border-0 shadow-none">' +
            '<div class="card-header d-flex align-items-center justify-content-center" style="background: linear-gradient(to right, rgb(67, 206, 162), #1abc9c);padding:40px;border-top-left-radius: 15px;border-top-right-radius: 15px;">' +
            '<span style="color:white">' +
            '<i class="fa-regular fa-circle-check fa-6x"></i>' +
            '</span>' +
            '</div>' +
            '<div style="padding: 25px;text-align: center;color: #7c7c7c;">' +
            '<p><strong>Voto registrado com sucesso!</strong></p>' +
            '<p>Clique no botão abaixo para gerar o comprovante.</p>' +
            '<a class="btn btn-primary botao" href="' +
            rota_final + '" style="background: #e57373!important;border: 0px;">Gerar comprovante</a>' +
            '</div>' +
            '</div>';

        $('#area_votacao').empty().html(confirmacao);

    }

    function tabelaVotacao($id) {
        var listas_id = $('#tabelaVotacao').val();
        let route = "{{ route('Votacao_Json', [':id']) }}";
        route = route.replace(":candidatos", id);
        $('#tabelaVotacao').DataTable({
            ajax: {
                url: route,
                dataSrc: ''
            },
            columnDefs: [{
                orderable: false,
                targets: 0
            }],

            info: false,
            searching: false,
            paging: false,
            ordering: false,


            select: {
                style: 'single'
            },
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
            },
            columns: [

                {
                    data: null,
                    render: function(data, type, row) {
                        var caminhorecebeFoto = "{{asset("storage ")." / "}}" + data.foto;
                        return '<img  class="foto" style="height:150px" src="' + caminhorecebeFoto + '">'
                    }
                },

                {
                    data: "nome"
                },
                {
                    data: "apelido"
                },
                {
                    data: "cargo_funcao"
                },
                {
                    data: "lotacao"
                },
                {
                    data: "matricula"
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0)" data-toggle="tooltip" onClick="confirmarVotacao(' +
                            data.id +
                            ')" data-original-title="Edit" class="btn btn-primary botao" id="votar" >Votar</a>';
                    }
                }
            ],
        });
    };

    function verificarPeriodoVotacao() {
  $.ajax({
    type: 'GET',
    url: "{{ route('verificar_periodo_votacao') }}",
    dataType: 'json',
    success: function(response) {
      if (response.in_periodo_votacao) {
        confirmarVotacao(id, candidatoNome);
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Fora do período de votação!',
          text: 'O período de votação já encerrou ou ainda não começou.',
          showConfirmButton: false,
          timer: 3000
        });
      }
    },
    error: function(err) {
      console.log(err);
      Swal.fire({
        icon: 'error',
        title: 'Erro ao verificar período de votação!',
        text: 'Por favor, tente novamente mais tarde.',
        showConfirmButton: false,
        timer: 3000
      });
    }
  });
}


    function confirmarVotacao(id, candidatoNome) {
    Swal.fire({
        icon: 'question',
        title: 'Você selecionou o(a) Candidato(a) ' + candidatoNome + ' para Votação. Confirma?',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.isConfirmed) {
            $('input[type="checkbox"]').prop('checked', false);
            $('input[type="branco"]').prop('checked', false);
            let route = "{{ route('Votacao_Store')}}";
            $.ajax({
                type: 'POST',
                url: route,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    eleicoes_id: "{{ $eleicoes->id}}",
                    tipo: "V",
                    voto_candidato_id: id,
                    cargo_funcao: "{{ $eleitor->ds_cargo}}",
                    nome: "{{ $eleitor->nome}}",
                    cpf: "{{ $eleitor->cpf}}",
                    matricula: "{{ $eleitor->matricula}}",
                    lotacao: "{{ $eleitor->lotacao}}",
                    IP_acesso: "{{ $eleitor->IP_acesso}}",
                },
                dataType: 'json',
            }).done(function(resp) {
                if (resp.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Algo saiu Errado!',
                        text: resp.error,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    apresentarConfirmacao(resp.id);
                }
            }).fail(function(err) {
    if (err.responseJSON && err.responseJSON.error) {
        Swal.fire({
            icon: 'error',
            title: 'Algo saiu Errado!',
            text: err.responseJSON.error,
            showConfirmButton: false,
            timer: 3000
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Algo saiu Errado!',
            text: "Matrícula Logada já Votou nesta Eleição!",
            showConfirmButton: false,
            timer: 3000
        });
    }
});
            //window.location = "/votacao/comprovante"
            // prosseguir com a execução
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Por favor escolha um Candidato!',
                text: "Voto não Realizado!",
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
}

    /* Voto Nulo */
    $('#votos_nulo').click(function(e) {
        Swal.fire({
            icon: 'question',
            title: 'Você selecionou o Voto Nulo. Confirma?',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $('input[type="checkbox"]').prop('checked', false);
                $('input[type="branco"]').prop('checked', false);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('Votacao_Store') }}",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        eleicoes_id: "{{ $eleicoes->id }}",
                        tipo: "N",
                        cargo_funcao: "{{ $eleitor->ds_cargo }}",
                        matricula: "{{ $eleitor->matricula }}",
                        cpf: "{{ $eleitor->cpf }}",
                        nome: "{{ $eleitor->nome }}",
                        lotacao: "{{ $eleitor->lotacao }}",
                        IP_acesso: "{{ $eleitor->IP_acesso }}",
                    },
                }).done(function(resp) {
                    apresentarConfirmacao(resp.id);
                }).fail(function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Algo saiu Errado! Verifique.',
                        text: "Voto não Realizado!",
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Por favor escolha um Candidato!',
                    text: "Voto não Realizado!",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });
    /* Voto em Branco */
    $('#branco').click(function(e) {
        Swal.fire({
            icon: 'question',
            title: 'Você selecionou o Voto em Branco. Confirma?',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $('input[type="checkbox"]').prop('checked', false);
                $('input[type="votos_nulo"]').prop('checked', false);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('Votacao_Store') }}",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        eleicoes_id: "{{ $eleicoes->id }}",
                        tipo: "B",
                        cargo_funcao: "{{ $eleitor->ds_cargo }}",
                        matricula: "{{ $eleitor->matricula }}",
                        cpf: "{{ $eleitor->cpf }}",
                        nome: "{{ $eleitor->nome }}",
                        lotacao: "{{ $eleitor->lotacao }}",
                        IP_acesso: "{{ $eleitor->IP_acesso }}",
                    },
                }).done(function(resp) {
                    apresentarConfirmacao(resp.id);
                }).fail(function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Algo saiu Errado!',
                        text: "Voto não Realizado!",
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Por favor escolha seu candidato!',
                    text: "Voto não Realizado!",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });

    function escondeSelect() {
        $(document).ready(function() {
            $("#branco, #votos_nulo").hide();
        });
    }
</script>

@endsection