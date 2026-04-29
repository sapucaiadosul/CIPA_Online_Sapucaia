@extends('layouts.header')
@section('content')

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<input type="hidden" name="id" id="id">
<div class="container">
    <div class="card">
        <div class="card-header" style="background: linear-gradient(to right, rgb(67, 206, 162), #1abc9c);padding:10px;text-align: center;color:white">
            <h4 class="modal-title text-center">APURAÇÃO DE RESULTADOS DA CIPA</h4>
        </div>
        <div id="area_apuracao" class="card-header">

            <table id="tabelaCandidatos" name="tabelaCandidatos" class="table">

                @foreach($candidatos as $candidato)
                <tr>
                    <td class="coluna_foto"><img class="foto_candidato" src="{{asset('/storage') . '/' . $candidato->foto}}"></td>
                    <td style="padding: 16px !important;">
                        <table id="tabela_dados">
                            <tr>
                                <td colspan="2"><Strong>Nome: </Strong>{{ $candidato->nome }}</td>
                            </tr>
                            <tr>
                                <td><strong>Matrícula:</strong> {{ $candidato->matricula}}</td>
                                <td><strong>Apelido:</strong> {{ $candidato->apelido }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><Strong>Cargo: </Strong>{{ $candidato->cargo_funcao }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Lotação:</strong> {{ $candidato->lotacao }}</td>

                            </tr>
                        </table>
                    </td>

                    <td><a href="javascript:void(0)" data-toggle="tooltip" onClick="confirmarVotacao(' {{ $candidato->id }} ')" data-original-title="Edit" class="btn btn-primary botao" style="min-width: 100px !important" id="votar">Votar</a></td>
                </tr>


                @endforeach
            </table>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-secondary botao botao_branco" id="branco"><i style="padding-right: 10px;" class="fa-regular fa-file"></i>Votar em Branco</button>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-secondary botao botao_nulo" id="votos_nulo"><i style="padding-right: 10px;" class="fa-solid fa-xmark"></i>Votar Nulo</button>

                    <!-- <button type="submit" class="btn btn-dark"  id="voto" onClick="confirmarVotacao()">Voto</button>
                    <div id="mostrabotao">
                    </div> -->

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

        // console.log("id_votacao" + id_votacao);
        var rota = '{{ route('
        Votacao_Comprovante ',['
        id_votacao ' => ":id_votacao" ])}}';
        var rota_final = rota.replace(':id_votacao', id_votacao);
        // console.log("rota final" + rota_final);
        //var rota_final = "{{" + rota + "}}";
        //console.log(rota_final);

        var confirmacao = '<p> Seu voto foi registrado com Sucesso! Clique <a href="' +
            rota_final + '"> aqui </a> para acessar o comprovante de votação.';

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
                        var caminhorecebeFoto = "{{ asset('storage') }}/" + data.foto;
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

    function confirmarVotacao(id) {
        if (confirm("Você selecionou um Candidato para Votação. Confirma?")) {
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
                    IP_acesso: "{{ $eleitor->IP_acesso }}",
                },
                dataType: 'json',
            }).done(function(resp) {
                // console.log(resp);
                apresentarConfirmacao(resp.id);
                //$('#tabelaVotacao').css({display: 'none'});
                //escondeSelect();
                //mostramensagem();

                }).fail(function(err) {
                    let mensagem = 'Voto não realizado. Verifique os dados e tente novamente.';

                    if (err.responseJSON && err.responseJSON.error) {
                        mensagem = err.responseJSON.error;
                    } else if (err.responseJSON && err.responseJSON.message) {
                        mensagem = err.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Algo saiu Errado!',
                        text: mensagem,
                        showConfirmButton: false,
                        timer: 3000
                    });
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
    }
    /* Voto Nulo */
    $('#votos_nulo').click(function(e) {
        if (confirm("Você selecionou o Voto Nulo. Confirma?")) {
            $('input[type="checkbox"]').prop('checked', false);
            $('input[type="branco"]').prop('checked', false);
            $.ajax({
                type: 'POST',
                url: "{{ route('Votacao_Store') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    eleicoes_id: "{{ $eleicoes->id}}",
                    tipo: "N",
                    cargo_funcao: "{{ $eleitor->ds_cargo}}",
                    matricula: "{{ $eleitor->matricula}}",
                    cpf: "{{ $eleitor->cpf}}",
                    nome: "{{ $eleitor->nome}}",
                    lotacao: "{{ $eleitor->lotacao}}",
                    IP_acesso: "{{ $eleitor->IP_acesso}}",
                },
            }).done(function(resp) {
                apresentarConfirmacao(resp.id);
            }).fail(function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Algo saiu Errado! Verfique.',
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
    /* Voto em Branco */
    $('#branco').click(function(e) {
        if (confirm("Você selecionou o Voto em Branco. Confirma? ")) {
            $('input[type="checkbox"]').prop('checked', false);
            $('input[type="votos_nulo"]').prop('checked', false);
            $.ajax({
                type: 'POST',
                url: "{{ route('Votacao_Store') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    eleicoes_id: "{{ $eleicoes->id}}",
                    tipo: "B",
                    cargo_funcao: "{{ $eleitor->ds_cargo}}",
                    matricula: "{{ $eleitor->matricula}}",
                    cpf: "{{ $eleitor->cpf}}",
                    nome: "{{ $eleitor->nome}}",
                    lotacao: "{{ $eleitor->lotacao}}",
                    IP_acesso: "{{ $eleitor->IP_acesso}}",
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

    function escondeSelect() {
        $(document).ready(function() {
            $("#branco, #votos_nulo").hide();
        });
    }
</script>

@endsection
