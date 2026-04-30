<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style>
    .table {
        margin-bottom: 0px;
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
        border-top: 0px;
    }
    .borda {
        border-radius: 5px;
        border: 1px solid rgb(87, 89, 98);
        margin-bottom: 12px;
    }
    .table-condensed>tbody>tr>td,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>td,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>thead>tr>th {
        padding: 3px;
    }

    .table {
        margin-bottom: 0px;
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
        border-top: 0px;
    }
    .borda {
        border-radius: 5px;
        border: 1px solid rgb(87, 89, 98);
        margin-bottom: 12px;
    }
    .table-condensed>tbody>tr>td,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>td,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>thead>tr>th {
        padding: 3px;
    }

    .footer {
        position: fixed; 
        bottom: -60px; 
        left: 0px; 
        right: 0px;
        height: 65px; 
        font-size: 10px;
        background-color: #d3d3d3;
        color: black;
        text-align: center;
        line-height: 15px;
    }

    .footer {
        bottom: 10px;
    }

</style>

<body>
    <header>
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="width:18%; text-align:left; vertical-align:top;">
                    <img src="{{ public_path('assets/img/logo_prefeitura.png') }}" style="width:129px;height:auto; margin-top: 1px; margin-left: 1px" />
                </td>
                <td style="width:64%; text-align:center; vertical-align:top;">
                    <h6>PREFEITURA MUNICIPAL DE SAPUCAIA DO SUL</h6>
                    <h6>Estado do Rio Grande do Sul</h6>
                    <h6>SETOR DE SEGURANÇA DO TRABALHO</h6>
                    <h6>Av. Leônidas de Souza, 1289 - Santa Catarina - Sapucaia do Sul</h6>
                    <h6>(51) 3451-8062</h6>
                    <h6>sesmt@saoleopoldo.rs.gov.br</h6>
                    <h6>ELEIÇÃO: {{$pdfInscricao->Eleicoes->descricao_eleicao}}</h6>
                    <h6>COMPROVANTE DE INSCRIÇÃO DO CANDIDATO</h6>
                </td>
                <td style="width:18%; text-align:right; vertical-align:top;">
                    <img src="{{ public_path('assets/img/logo_cipa.png') }}" style="width:75px;height:75px; margin-top: 10px; margin-right: 1px" />
                </td>
            </tr>
        </table>
    </header>
    <div class="borda">
        <table class="table table-sm table-condensed">
            <tbody>
                <tr>
                    <td style="width: 70"><strong>DADOS DO CANDIDATO</strong></td></tr>
                    </br>
                    <tr><td style="width: 70%"><Strong>Eleição Comissão CIPA: </Strong>{{$pdfInscricao->Eleicoes->descricao_eleicao}}</td></tr>
                    <tr><td style="width: 70%"><Strong>Nº de Inscrição: </Strong>{{ $pdfInscricao->id }}</td></tr>
                    <tr><td style="width: 70%"><strong>Data/Hora de Inscrição: </strong>{{ date('d/m/Y H:i', strtotime($pdfInscricao->created_at)) }}</td></tr>
                    <br>
                    <tr><td style="width: 70%"><Strong>Matrícula: </Strong>{{ $pdfInscricao->matricula }}</td></tr>
                    <tr><td style="width: 70%"><strong>Nome do Candidato: </strong>{{ $pdfInscricao->nome }}</td></tr>
                    <tr><td style="width: 70%"><strong>Apelido:</strong> {{ $pdfInscricao->apelido }}</td></tr>
                    @if ($pdfInscricao->cpf !=null)   
                        <tr><td style="width: 70%"><strong>CPF: </strong>{{ substr($pdfInscricao->cpf,0,3).'.'.substr($pdfInscricao->cpf,3,3).'.'.substr($pdfInscricao->cpf,6,3).'-'.substr($pdfInscricao->cpf,9,2)}}</td></tr>
                    @else    
                        <tr><td style="width: 70%"><strong>CPF: </strong> Não informado</td></tr>
                    @endif   
                    <tr><td style="width: 70%"><strong>e-mail: </strong>{{ $pdfInscricao->email }}</td></tr>
                    <tr><td style="width: 70%"><strong>Telefone: </strong>{{ $pdfInscricao->telefone }}</td></tr>
                    <tr><td style="width: 70%"><strong>Data de Nascimento: </strong>{{ date('d/m/Y', strtotime($pdfInscricao->dt_nascimento)) }}</td></tr>
                    <tr><td style="width: 70%"><strong>Lotação: </strong>{{ $pdfInscricao->lotacao }}</td></tr>
                    <tr><td style="width: 70%"><strong>Cargo/Função: </strong>{{ $pdfInscricao->cargo_funcao }}</td></tr>
                    <tr><td style="width: 70%"><strong>Histórico/Biografia: </strong>{{ $pdfInscricao->historico }}</td></tr>
                </tr>
            </tbody>
        </table>
    </div>

    <footer>
        <div class="footer">
            <!-- <span> Copyright © <?php echo date("Y");?> - Desenvolvimento</span> -->
            <span> Prefeitura Municipal de Sapucaia do Sul </span><br> 
            <span> Av. Leônidas de Souza, 1289 - CEP: 93210-140 </span><br> 
            <span> (51) 3451-8062 </span></br> 
            <span> Cidade das oportunidades <span> 
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>
