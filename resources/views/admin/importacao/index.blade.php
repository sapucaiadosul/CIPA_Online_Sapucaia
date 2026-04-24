@extends('admin.layouts.master')
@section('title','Importações')
@section('content')
@include('flash::message')
@if(session('ImportacaoConcluida'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Importação realizada com sucesso!',
        showConfirmButton: false,
        timer: 3000
    })
</script>
@endif
@if(session('ArquivoInvalido'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erro...',
        text: 'O arquivo deve estar no formato .xls, .xlsx, .csv ou .ods.'
    })
</script>
@endif
@if(session('SemArquivo'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erro...',
        text: 'Não foi enviado nenhum arquivo.'
    })
</script>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="modal-title">IMPORTAR SERVIDORES</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('/importar-servidor') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="arquivo" id="input-arquivo" accept=".xlsx,.xls,.csv,.ods" hidden required>

            <div id="info-arquivo" style="display:none;" class="mb-2">
                <small class="text-muted">
                    <i class="fas fa-file mr-1"></i>
                    <span id="nome-arquivo"></span>
                </small>
            </div>

            <button type="button" id="btn-acao" class="btn btn-info mr-2">
                Selecionar arquivo
            </button>

            <button type="button" id="btn-remover" class="btn btn-danger" style="display:none;">
                Remover arquivo
            </button>
        </form>
    </div>
</div>

<script>
    const input = document.getElementById('input-arquivo');
    const btnAcao = document.getElementById('btn-acao');
    const btnRem = document.getElementById('btn-remover');
    const nomeSpan = document.getElementById('nome-arquivo');
    const infoArquivo = document.getElementById('info-arquivo');
    let selecionado = false;

    btnAcao.addEventListener('click', () => {
        if (!selecionado) {
            input.click();
        } else {
            btnAcao.disabled = true;
            btnAcao.textContent = 'Enviando...';
            input.closest('form').submit();
        }
    });

    input.addEventListener('change', () => {
        if (input.files.length > 0) {
            selecionado = true;
            nomeSpan.textContent = input.files[0].name;
            infoArquivo.style.display = 'block';
            btnAcao.textContent = 'Enviar arquivo';
            btnRem.style.display = 'inline-block';
        }
    });

    btnRem.addEventListener('click', () => {
        input.value = '';
        selecionado = false;
        nomeSpan.textContent = '';
        infoArquivo.style.display = 'none';
        btnAcao.textContent = 'Selecionar arquivo';
        btnAcao.disabled = false;
        btnRem.style.display = 'none';
    });
</script>
@endsection