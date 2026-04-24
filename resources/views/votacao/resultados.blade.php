@extends('layouts.header')
@section('title','CIPA Online')
@section('content')
@include('flash::message')

@if(session('NaoVeResultados'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'A visualização dos Resultados da Eleição não está liberada neste momento!',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 3000
        })
    </script>
@endif


@if($exibir_mensagem)

<div>
    <div class="card-header text-white" style="background: #1abc9c">
        <h4 class="col-12 modal-title text-center">RESULTADOS DA ELEIÇÃO</h5>
    </div>
    <div class="d-flex justify-content-center" style="padding-top: 20px">
        <div class="col-md-6">
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
    <div class="d-flex justify-content-center" >
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="container col-md-12">
                        <div class="card">
                            <div class="container-fluid no-padding table-responsive-sm">
                                <table class="table table-striped nowrap" style="width:100%" id="exemplo">
                                    <h5 class="col-12 modal-title text-center p-4">Lista de detalhes dos candidatos</h5>
                                    <thead align="center">
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nome</th>
                                            <th>Apelido</th>
                                            <th>Matrícula</th>
                                            <th>Cargo/Função</th>
                                            <th>Total votos</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                </table>
                                <div class="container col-md-12 text-center">
                                    <div class="card-header">
                                            <div id="resultados"></div>
                                    </div>
                                </div>
        </div>
    </div>

@else
 Não há eleições encerradas!
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"crossorigin="anonymous">
</script>

<script>
    tabelaResultados();
    function tabelaResultados() {
    let route = "{{ route('Votacao_Resultados_Json')}}";
    $.ajax({
        url: route,
        success: function(data) {
            if (data.length > 0) {
                $('#exemplo').DataTable({
                    ajax: {
                        url: route,
                        dataSrc: ''
                    },
                    "bFilter": false,
                    columns: [
                        {
                    data: null,
                    render: function(data, type, row) {
                        var caminhorecebeFoto = "{{ asset('storage') }}/" + data.foto;
                        return '<img id="foto" class="avatar-img rounded-circle" style="margin-top: 5px; margin-bottom: 5px; width: 100px; height: 100px; object-fit: cover;" src="' + caminhorecebeFoto + '">'
                    }
                },
                { data: "nome" },
                { data: "apelido" },
                { data: "matricula" },
                { data: "cargo_funcao" },
                { data: "total_votos" },
                    ],
                    select: false,
                     responsive: true,
                      info: false,
                      searching: true,
                      paging: true,
                       ordering: true,
        "order": [
            [0, "asc"]
        ],
        "info": true,
        "sLengthMenu": false,
        "bLengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de MAX registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "MENU resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "",
                "sPrevious": "",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
                    }
                });
            } else {
                $('#resultados').html(data.message);
            }
        },
        error: function() {
            $('#resultados').html('Erro ao buscar dados');
        }
    });
}
</script>

<script>
    $(document).ready(function() {
        let route = "{{ route('Votacao_Resultados_Json')}}";
        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#tabela-votacao-candidatos').empty();
                if (data.length === 0) {
                    var linha = '<tr><td colspan="6">Ainda não temos dados definidos!</td></tr>';
                    $('#tabela-votacao-candidatos').append(linha);
                } else {
                    $.each(data, function(index, votacao_candidato) {
                        var resultado = '';
                    if (index < 6) {
                        resultado = 'Titular Eleito';
                    } else if (index >= 6 && index < 11) {
                        resultado = 'Suplente';
                    }

                    var caminhorecebeFoto = "{{ asset('storage') }}/" + votacao_candidato.foto;

                    var linha = 
                        '<div class="card">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title"><strong>Apurações do Candidato :</strong>' +
                        (votacao_candidato.nome || ' Aguarde!!') + '</h5>'+
                        '<strong>Matrícula: </strong>' +
                        (votacao_candidato.matricula || '') + '<br>' +
                        '<strong>Resultado: </strong>' +
                        resultado +
                        '</div>' +
                        '</div>';
                        $('#tabela-votacao-candidatos').append(linha);
                    });
                }
            }
        });
    });
</script>

@endsection
