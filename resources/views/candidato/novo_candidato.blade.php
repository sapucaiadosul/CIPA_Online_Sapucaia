@extends('layouts.header')
@section('title','CIPA Online')
@section('content')

@if(session('$validator'))
<script>
    Swal.fire({
        icon: 'danger',
        title: 'Verifique seu arquivo de foto!',
        showConfirmButton: false,
        timer: 3000
    })
</script>
@endif

@if(session('CadastrarCandidato'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Inscrição Realizada com Sucesso!',
        showConfirmButton: false,
        timer: 3000
    })
</script>
@endif

<style type="text/css">
    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 200px;
        height: 200px;
        border: 1px solid red;
        position: relative;
    }

    .preview img {
        position: absolute;
        z-index: 1;
    }

    #textcanvas {
        position: relative;
        z-index: 20;
    }

    #side {
        padding: 10px;
    }

    .modal-lg {
        max-width: 1000px !important;
    }

    @media (max-width: 768px) {
        .container-form {
            width: 95% !important;
            padding: 10px;
        }
    }
</style>

<div class="container-form" style="width:60%;margin:auto;">
    <form class="form-horizontal" id="formInscricaoCandidato" method="post" action="{{ route('Candidato_Store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="id" class="form-control">
        <input type="hidden" id="eleicoes_id" name="eleicoes_id" value="{{$eleicao->id}}">

        <div class="card">
            <div class="card-header" style="background: linear-gradient(to right, rgb(67, 206, 162), #1abc9c);padding:15px;text-align: center;color:white">
                <span style="color:white">
                    <i class="fa-regular fa-pen-to-square fa-xl"></i>
                </span>
                <h4 class="col-12 modal-title text-center mb-2">INSCRIÇÃO DE CANDIDATO</h4>
                <h6 class="mb-0">ELEIÇÃO CIPA: {{$eleicao->descricao_eleicao}}</h6>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="form-row">
                    <div class="container">
                        <div class="form-group col-12">
                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <label for="matricula" class="control-label">Matrícula:</label>
                                    <div class="input-group">
                                        <input type="matricula" class="form-control" id required="matricula" name="matricula" readonly placeholder="Matrícula" value="{{ $candidatoAutenticado->matricula }}">
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-8">
                                    <label for="nome" class="control-label">Nome Completo:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="nome" name="nome" readonly placeholder="Nome Completo" value="{{ $candidatoAutenticado->nome }}">
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="cpf" class="control-label">CPF:</label>
                                    <div class="input-group">
                                        <input type="string" class="form-control cpf" id="cpf" name="cpf" readonly placeholder="000.000.000-00" value="{{ $candidatoAutenticado->cpf }}">
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="dt_nascimento" class="control-label">Data de Nascimento:</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" placeholder="Data de Nascimento" value="{{ $candidatoAutenticado->dt_nascimento }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="lotacao" class="control-label">Lotação:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="lotacao" name="lotacao" readonly placeholder="Lotação" value="{{ $candidatoAutenticado->departamento }}">
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="cargo_funcao" class="control-label">Cargo/Função:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="cargo_funcao" name="cargo_funcao" readonly placeholder="Cargo/Função" value="{{ $candidatoAutenticado->ds_cargo }}">
                                    </div>
                                </div>

                                <input type="text" class="form-control" id="cd_vinculo" name="cd_vinculo" value="{{ $candidatoAutenticado->cd_vinculo }}" hidden>

                                <div class="form-group col-12 col-md-6">
                                    <label for="nome" class="control-label">Apelido:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="apelido" name="apelido" autofocus required placeholder="Apelido" value="{{ old('apelido') }}">
                                        <span role="alert" id="apelidoError"></span>
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="telefone" class="control-label">Telefone/Celular:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control celular" id="telefone" name="telefone" required placeholder="(00) 0000-0000" value="{{ old('telefone') }}">
                                        <span role="alert" id="telefoneError"></span>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label for="email" class="control-label">E-mail:</label>
                                    <div class="input-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" required name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        <span role="alert" id="emailError"></span>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>Histórico/Biografia:</label>
                                    <div class="form-group shadow-textarea">
                                        <textarea name='historico' class="form-control z-depth-1" id="historico" rows="3" placeholder="Digite aqui um breve resumo do seu Histórico/Biografia..." required></textarea>
                                    </div>
                                </div>

                                <div id="mensagemFoto" style="color: red;"></div>

                                <div class="form-group col-12">
                                    <label for="foto" class="control-label">Carregue sua Foto:</label>
                                    <input type="file" class="image form-control-file" id="foto" name="foto" required style="border: 0px">
                                    <img id="previa-foto" class="mt-3 img-fluid" style="max-height: 250px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row w-100 justify-content-center mt-3 mb-4">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-4 text-center">
                            <button id="salvarBtn"
                                onclick="enviarDados()"
                                class="btn btn-primary botao"
                                style="width:70%">
                                Salvar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {!! JsValidator::formRequest('App\Http\Requests\CandidatoRequest') !!}

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Recorte sua Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Enquadre sua foto no retângulo abaixo:</p>
                    <div class="img-container mx-auto" style="max-width: 100%;">
                        <img id="image" class="img-fluid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="crop">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <script type="text/javascript" src="{{ asset('js/jsvalidation.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/validator/13.6.0/validator.min.js"></script>
        <style>
            .error {
                outline: 2px solid red;
            }
        </style>
    </div>
</div>
<script>
    $('#cpf').mask('999.999.999-99');
    $('.celular').mask('(00) 00000-0000');
    $('.telefone').mask('(00) 0000-0000');
    $('.dinheiro').mask('00.000,00', {
        reverse: false
    });
    $('.numero').mask('00000', {
        reverse: false
    });
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var cropper;
    var save_black_white = false;

    $("body").on("change", ".image", function(e) {
        var files = e.target.files;
        var extensaoNaoPermitida = false;
        var excedeuLimiteTam = false;
        var mensagemValidacao = "";
        if (files.length > 0) {
            var nomeArquivo = files[0].name;
            var extensao = nomeArquivo.substr(nomeArquivo.lastIndexOf("."));
            var allowedExtensionsRegx = new RegExp(/(jpg|jpeg|png|JPG|JPEG|PNG)$/);
            var extensaoNaoPermitida = !(allowedExtensionsRegx.test(extensao));

            if (extensaoNaoPermitida)
                mensagemValidacao += "É permitido apenas imagens com extensão: JPG, JPEG e PNG!";

            if (files[0].size >= 5242880)
                excedeuLimiteTam = true;
            if (excedeuLimiteTam)
                mensagemValidacao += "O limite de tamanho é 5MB para a foto!";

            if (excedeuLimiteTam || extensaoNaoPermitida) {
                $("#foto").val(null);
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao selecionar a imagem',
                    text: mensagemValidacao,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                var done = function(url) {
                    image.src = url;
                    $modal.modal('show');
                };
                var reader;
                var file;
                var url;

                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            dragMode: 'move',
            preview: '.preview',
            rotatable: true,
            center: true,
            highlight: false,
            cropBoxMovable: false,
            cropBoxResizable: false,
            crop(event) {},
        });

        $('#rotate-right').click(function() {
            cropper.rotate(45);
        });
        $('#rotate-left').click(function() {
            cropper.rotate(-45);
        });
        $('#greyscale').click(function() {
            $('.preview').css({
                'mix-blend-mode': 'luminosity',
            });
            save_black_white = true;
        });
        $('#reset-greyscale').click(function() {
            $('.preview').css({
                'mix-blend-mode': '',
            });
            save_black_white = false;
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 200,
            height: 200,
        });
        const ctx = canvas.getContext("2d");

        var base64data = canvas.toDataURL();

        $('#previa-foto').attr('src', base64data);
        $modal.modal('hide');
        $('#mensagemFoto').empty()
    });

    function wrapText(context, text, x, y, maxWidth, lineHeight) {
        var words = text.split(' ');
        var line = '';
        for (var n = 0; n < words.length; n++) {
            var testLine = line + words[n] + ' ';
            var metrics = context.measureText(testLine);
            var testWidth = metrics.width;
            if (testWidth > maxWidth && n > 0) {
                context.fillText(line, x, y);
                line = words[n] + ' ';
                y += lineHeight;
            } else {
                line = testLine;
            }
        }
        context.fillText(line, x, y);
    }

    function drawCanvas(textcanvas, context) {

        var pushto = document.getElementById("crop-preview");

        try {
            context.clearRect(0, 0, textcanvas.width, textcanvas.height);
        } catch (err) {

        }
    }

    $('#formInscricaoCandidato').submit(function(e) {
        e.preventDefault();
        formCandidato = document.getElementById("formInscricaoCandidato");

        stringBase64Foto = $('#previa-foto').attr('src');

        if (stringBase64Foto && $("#telefone").val() != '' && $("#email").val() != '' && $("#apelido").val() != '') {
            var campoImagemCortada = document.createElement("input");
            campoImagemCortada.setAttribute("type", "hidden");
            campoImagemCortada.setAttribute("name", "foto_cortada");
            campoImagemCortada.setAttribute("value", stringBase64Foto);
            formCandidato.appendChild(campoImagemCortada);
            formCandidato.submit();
            $("#salvarBtn").prop("disabled", true);

        } else {

            if (!stringBase64Foto) {
                $('#mensagemFoto').empty().html('A foto precisa ser anexada!');
            } else {
                $('#mensagemFoto').empty()
            }

            Swal.fire({
                icon: 'error',
                title: 'Erro ao enviar o formulário',
                text: 'Verifique os campos!',
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
</script>
@endsection