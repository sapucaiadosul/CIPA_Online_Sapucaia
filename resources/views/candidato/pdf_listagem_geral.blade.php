<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<style>
    .table {
        margin-bottom: 25px;
        position: relative;

    }

    html,
    body {
        margin: 8px;
        padding: 8px;
    }

    .table-condensed {
        font-size: 13px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        border-top: 25px;
        position: fixed;
        bottom: 50px;
        position: relative;

    }

    .borda {
        border-radius: 5px;
        border: 1px solid rgb(87, 89, 98);
        margin-bottom: 15px;
    }

    .table-condensed>tbody>tr>td,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>td,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>thead>tr>th {
        padding: 3px;
        position: relative;
        background-color: #f5f5f5;

    }

    .footer {
        position: absolute;
        bottom: 0px;
        left: 0px;
        right: 0px;
        height: 65px;
        font-size: 10px;
        color: black;
        text-align: center;
        line-height: 15px;
    }

   
    header {
        position: fixed;
        top: 10px;
        left: 0px;
        right: 0px;
    }

    table {
        position: relative;

        left: 0px;
        right: 0px;
        background-color: #f5f5f5;
    }

    table:first-of-type {
        padding-top: 10px;
        position: relative;
        top: 10;
        background-color: #f5f5f5;
    }
</style>

    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="width:18%; text-align:left; vertical-align:top;">
                <img src="{{ public_path('assets/img/logo_prefeitura.png') }}" style="width:129px;height:auto; margin-top: 1px; margin-left: 1px" />
            </td>
            <td style="width:64%; text-align:center; vertical-align:top;">
                <h6>PREFEITURA MUNICIPAL DE SAPUCAIA DO SUL</h6>
                <h6>Estado do Rio Grande do Sul</h6>
                <h6>SETOR DE SEGURANÇA DO TRABALHO</h6>
                <h6>Av. Leônidas de Souza 128 - Bairro: Santa Catarina - Sapucaia do Sul</h6>
                <h6>(51) 3451-8062</h6>
                <h6>sesmt@saoleopoldo.rs.gov.br</h6>
                <h6>{{ $eleicoes->descricao_eleicao }}</h6>
                <h6>LISTAGEM GERAL DOS CANDIDATOS</h6>
            </td>
            <td style="width:18%; text-align:right; vertical-align:top;">
                <img src="{{ public_path('assets/img/logo_cipa.png') }}" style="width:75px;height:75px; margin-top: 10px; margin-right: 1px" />
            </td>
        </tr>
    </table>

<body>
    
    @php
        $totalCandidatos = count($candidatos_filtro);
        $i = 0;
    @endphp
    <div>
    @foreach ($candidatos_filtro as $candidato)
        @if($i % 5 == 0 && $i > 0)
            <div style="page-break-after: always;"></div>
        @endif

   
    <table class="table table-sm table-condensed">
        <tbody>
            <tr>
                <td style="width: 30%"><strong>Nº de Inscrição: </strong>{{ $candidato->id }}</td>
                <td colspan="2" style="width: 70%"><strong>Nome do Candidato: </strong> {{ $candidato->nome }}</td>
            </tr>
            <tr>
                <td style="width: 100%"><Strong>Matrícula: </Strong>{{ $candidato->matricula }}</td>
                <td style="width: 100%"><strong>Data de Nascimento: </strong>{{ date('d/m/Y', strtotime($candidato->dt_nascimento)) }}</td>
                <td style="width: 100%"><strong>Apelido:</strong> {{ $candidato->apelido }}</td>
            </tr>
            <tr>
                <td style="width: 100%"><strong>CPF: </strong>{{ substr($candidato->cpf,0,3).'.'.substr($candidato->cpf,3,3).'.'.substr($candidato->cpf,6,3).'-'.substr($candidato->cpf,9,2)}}</td>
                <td colspan="2"><strong>Data/Hora de Inscrição: </strong>{{ date('d/m/Y h:m', strtotime($candidato->created_at)) }}</td>
            </tr>
            <tr>
                <td style="width: 100%"><strong>Telefone: </strong>{{ $candidato->telefone }}</td>
                <td colspan="2"><strong>Cargo/Função: </strong>{{ $candidato->cargo_funcao }}</td>
            </tr>
            <tr>
                <td style="width: 100%"><strong>E-mail: </strong>{{ $candidato->email }}</td>
                <td colspan="2"><strong>Lotação: </strong>{{ $candidato->lotacao }}</td>
            </tr>


        </tbody>
    </table>
    
    </div>
    @php
       $i++;
    @endphp
    @if($i == $totalCandidatos)
       @break
    @endif
    @endforeach
    <footer>
                <div class="footer">
                    <span> Prefeitura Municipal de Sapucaia do Sul </span><br>
                    <span> Av. Leônidas de Souza, 1289 - CEP: 93210-140 </span><br>
                    <span> (51) 3451-8062 </span></br>
                    <span> Cidade das oportunidades <span>
                </div>
            </footer>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
