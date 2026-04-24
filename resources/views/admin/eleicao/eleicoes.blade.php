@extends('admin.layouts.master')
@section('title','CIPA Online')
@section('content')

@if(session('CadastrarEleicao'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Dados da Eleição Cadastrados com Sucesso!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('DatasVigência'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Datas de Vigência Incoerentes!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('DatasInscrição'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Datas de Inscrição Incoerentes!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('DatasVotação'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Datas de Votação Incoerentes!',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  
@if(session('DataResultado'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Data do Resultado deve ser maior que Data de Votação até',
            showConfirmButton: false,
            timer: 3000
        })
    </script>    
@endif  

<form class="form-horizontal" method="post" action="{{ route('Eleicoes_Store') }}" onsubmit="mostrarTelaCarregando()" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="id" class="form-control">

    <div class="card">
        <div class="card-header">
            <h4 class="col-12 modal-title text-center">DADOS DE ELEIÇÕES</h4>
        </div>
        <div class="form-row">
            <div class="container col-md-12">
                <div class="form-group col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="descricao_eleicao" class="control-label">Descrição da Eleição:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="descricao_eleicao" name="descricao_eleicao" required
                                    placeholder="Descrição da Eleição" value="{{ isset($eleicoes->descricao_eleicao) ? $eleicoes->descricao_eleicao : old('descricao_eleicao') }}">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="numero_indicados" class="control-label">Número de Indicados:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="numero_indicados" name="numero_indicados"  disabled
                                    placeholder="Número de Indicados" value="{{ old('numero_indicados',11) }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="numero_nao_indicados" class="control-label">Número de Inscritos(Não Indicados):</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="numero_nao_indicados" name="numero_nao_indicados"  disabled
                                    placeholder="Número de Inscritos (Não Indicados)" value="{{ old('numero_nao_indicados') }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="numero_eleitos" class="control-label">Número de Eleitos:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="numero_eleitos" name="numero_eleitos"  disabled
                                    placeholder="Número de Eleitos" value="{{ old('numero_eleitos') }}">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="dt_vigencia_de" class="control-label">Data/Hora de Vigência de:</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dt_vigencia_de" name="dt_vigencia_de" required
                                    placeholder="Data/Hora de Vigência de" value="{{ old('dt_vigencia_de') }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="dt_vigencia_ate" class="control-label">Data/Hora de Vigência até:</label> 
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dt_vigencia_ate" name="dt_vigencia_ate" required
                                    placeholder="Data/Hora de Vigência até" value="{{ old('dt_vigencia_ate') }}">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="dt_inscricao_de" class="control-label">Data/Hora de Inscrição de:</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dt_inscricao_de" name="dt_inscricao_de" required
                                    placeholder="Data/Hora de Inscrição de" value="{{ old('dt_inscricao_de') }}">
                            </div>
                        </div>
 
                        <div class="form-group col-md-3">
                            <label for="dt_inscricao_ate" class="control-label">Data/Hora de Inscrição até:</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dt_inscricao_ate" name="dt_inscricao_ate" required
                                    placeholder="Data/Hora de Inscrição até" value="{{ old('dt_inscricao_ate') }}">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="dt_votacao_de" class="control-label">Data/Hora de Votação de:</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dt_votacao_de" name="dt_votacao_de" required
                                    placeholder="Data/Hora de Votação de" value="{{ old('dt_votacao_de') }}">
                            </div>
                        </div>
         
                        <div class="form-group col-md-3">
                            <label for="dt_votacao_ate" class="control-label">Data de Votação até:</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dt_votacao_ate" name="dt_votacao_ate" required
                                    placeholder="Data/Hora de Votação até" value="{{ isset($eleicoes->dt_votacao_ate) ? $eleicoes->dt_votacao_ate : old('dt_votacao_ate') }}">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="dt_resultados" class="control-label">Data/Hora dos Resultados:</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dt_resultados" name="dt_resultados" required
                                    placeholder="Data/Hora dos Resultados" value="{{ isset($eleicoes->dt_resultados) ? $eleicoes->dt_resultados : old('dt_resultados') }}">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="dt_edital_nominal" class="control-label">Data do Edital Nominal dos Candidatos:</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dt_nominal_edital" name="dt_edital_nominal" required
                                    placeholder="Data do Edital Nominal dos Candidatos" value="{{ isset($eleicoes->dt_edital_nominal) ? $eleicoes->dt_edital_nominal : old('dt_edital_nominal') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label class="control-label">ANEXOS:</label>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="arquivo" class="custom-file-upload">
                                    <a class="btn btn-outline-secondary btn-sm"><i class="fa fa-cloud-upload"></i> Anexar Documentos</a>
                                </label>
                                <input style="display:none" type="file" name="arquivo[]" class="custom-file-unput" id="arquivo" multiple>
                                    <div ID="arquivos_selecionados"></div>
                  
                            <label for="obs_anexos" class="control-label">Observações sobre Anexos:</label>
                            <div class="input-group ">
                                <input type="text" class="form-control" name="obs_anexos" id="obs_anexos"
                                    value="{{ old('obs_anexos') }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</form>

<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script>
    var selDiv = "";
    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
        document.querySelector('#arquivo').addEventListener('change', handleFileSelect, false);
        selDiv = document.querySelector("#arquivos_selecionados");
    }
            
    function handleFileSelect(e) {
        if(!e.target.files) return;
        var files = e.target.files;
    
        var extensaoNaoPermitida = false;
        var excedeuLimiteTam = false;
        var mensagemValidacao = "";

        if (files.length>0){

        for(var i=0; i<files.length; i++) {

            var nomeArquivo = files[i].name;
            var extensao = nomeArquivo.substr(nomeArquivo.lastIndexOf("."));
            var allowedExtensionsRegx = /(\.pdf)$/i;
            
            var extensaoNaoPermitida = !(allowedExtensionsRegx.test(extensao));
        
        }
        if (extensaoNaoPermitida)
        mensagemValidacao += "São permitidos apenas arquivos em PDF!";

        for(var i=0; i<files.length; i++) {
            var tamanho = files[i].size;
            if (tamanho >= 3145728)
            excedeuLimiteTam = true;
        }
        if (excedeuLimiteTam)
        mensagemValidacao += "O limite de tamanho é 3MB para cada anexo!";
        
        if (excedeuLimiteTam || extensaoNaoPermitida){
            //document.getElementById("arquivos_candidato").value = "";
            selDiv.innerHTML = "";
            alert(mensagemValidacao);
            return;
        }
                    
        selDiv.innerHTML = "";
        selDiv.innerHTML = "Você selecionou " + files.length ;
        if (files.length>1) 
        selDiv.innerHTML += " arquivos:<br/>";
        else
        selDiv.innerHTML += " arquivo:<br/>";
        
        for(var i=0; i<files.length; i++) {
            var f = files[i];
            var tamanho = files[i].size;
            
            selDiv.innerHTML +=  '<i class="fa fa-file"></i> ' + (i+1) + " - " + f.name + " - ";
            
            if (tamanho >= 1048576)
            selDiv.innerHTML +=  (files[i].size / 1024 / 1024).toFixed(2).replace('.',',') + "MB" + "<br/>";
            else
            selDiv.innerHTML +=  (files[i].size / 1024).toFixed(2).replace('.',',')  + "KB" + "<br/>";
        }
    }
}
</script>
@endsection
