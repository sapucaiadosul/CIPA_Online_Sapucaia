@extends('admin.layouts.master')
@section('title','Servidores')
@section('content')
@include('flash::message')

@if(session('ImportacaoConcluida'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Importação realizada com sucesso!',
        text: "{{ session('ImportacaoConcluida') }} servidor(es) importado(s).",
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
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title mb-0">LISTA DE SERVIDORES</h5>
        <div class="d-flex align-items-center" style="gap: 0.5rem;">
            <form action="{{ url('/importar-servidor') }}" method="POST" enctype="multipart/form-data" id="form-importar" class="d-flex align-items-center" style="gap: 0.5rem;">
                @csrf
                <div id="input-wrapper"></div>
                <small id="info-arquivo" style="display:none;" class="text-muted">
                    <i class="fas fa-file mr-1"></i>
                    <span id="nome-arquivo"></span>
                </small>
                <button type="button" id="btn-remover" class="btn btn-outline-danger btn-sm" style="display:none;">
                    <i class="fas fa-times"></i> Remover
                </button>
                <button type="button" id="btn-acao" class="btn btn-info btn-sm">
                    <i class="fa fa-download mr-1"></i> Importar servidor(es)
                </button>
            </form>
        </div>
    </div>

    <div class="card-body pb-1">
        <form method="GET" action="{{ route('Servidor_Listar') }}">
            <div class="form-row align-items-end">
                <div class="col-md-4">
                    <label for="nome" class="col-form-label col-form-label-sm">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control form-control-sm" value="{{ request('nome') }}" placeholder="Filtrar por nome">
                </div>
                <div class="col-md-3">
                    <label for="matricula" class="col-form-label col-form-label-sm">Matrícula</label>
                    <input type="text" name="matricula" id="matricula" class="form-control form-control-sm" value="{{ request('matricula') }}" placeholder="Filtrar por matrícula">
                </div>
                <div class="col-md-3">
                    <label for="cpf" class="col-form-label col-form-label-sm">CPF</label>
                    <input type="text" name="cpf" id="cpf" class="form-control form-control-sm" value="{{ request('cpf') }}" placeholder="Filtrar por CPF">
                </div>
                <div class="col-md-2 d-flex" style="gap: 0.375rem;">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="fas fa-search mr-1"></i> Filtrar
                    </button>
                    @if(request('nome') || request('matricula') || request('cpf'))
                    <a href="{{ route('Servidor_Listar') }}" class="btn btn-secondary btn-sm flex-fill">
                        <i class="fas fa-times"></i> Limpar
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="container-fluid mt-2">
        <div class="table-responsive">
            <table class="table table-striped table-sm nowrap" id="exemplo">
                <thead align="center">
                    <tr>
                        <th>Nome</th>
                        <th>Matrícula</th>
                        <th>CPF</th>
                        <th>Data de nascimento</th>
                        <th>Vínculo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @forelse ($servidores as $servidor)
                    <tr>
                        <td>{{ $servidor->nome }}</td>
                        <td>{{ $servidor->matricula }}</td>
                        <td>{{ $servidor->cpf }}</td>
                        <td>{{ $servidor->dt_nascimento_formatada }}</td>
                        <td>{{ $servidor->vinculo }}</td>
                        <td>
                            <a href="{{ route('Servidor_Edit', $servidor->id) }}" class="btn btn-outline-secondary btn-sm" title="Editar">
                                Editar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum servidor encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2 mb-3">
            {{ $servidores->links('vendor.pagination.bootstrap-5', ['onEachSide' => 1]) }}
        </div>
    </div>
</div>

<script>
    const btnAcao = document.getElementById('btn-acao');
    const btnRem = document.getElementById('btn-remover');
    const nomeSpan = document.getElementById('nome-arquivo');
    const infoArquivo = document.getElementById('info-arquivo');
    const wrapper = document.getElementById('input-wrapper');
    let selecionado = false;

    function criarInput() {
        const novoInput = document.createElement('input');
        novoInput.type = 'file';
        novoInput.name = 'arquivo';
        novoInput.id = 'input-arquivo';
        novoInput.accept = '.xlsx,.xls,.csv,.ods';
        novoInput.hidden = true;
        novoInput.required = true;

        novoInput.addEventListener('change', () => {
            if (novoInput.files.length > 0) {
                selecionado = true;
                nomeSpan.textContent = novoInput.files[0].name;
                infoArquivo.style.display = 'inline';
                btnAcao.innerHTML = '<i class="fa fa-upload mr-1"></i> Importar arquivo';
                btnRem.style.display = 'inline-block';
            }
        });

        wrapper.innerHTML = '';
        wrapper.appendChild(novoInput);

        return novoInput;
    }

    let input = criarInput();

    btnAcao.addEventListener('click', () => {
        if (!selecionado) {
            input.click();
        } else {
            btnAcao.disabled = true;
            btnAcao.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Enviando...';
            document.getElementById('form-importar').submit();
        }
    });

    btnRem.addEventListener('click', () => {
        input = criarInput();
        selecionado = false;
        nomeSpan.textContent = '';
        infoArquivo.style.display = 'none';
        btnAcao.innerHTML = '<i class="fa fa-download mr-1"></i> Importar servidores';
        btnAcao.disabled = false;
        btnRem.style.display = 'none';
    });
</script>
@endsection