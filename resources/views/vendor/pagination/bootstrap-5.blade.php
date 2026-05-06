@if ($paginator->hasPages())
<nav aria-label="Navegação de páginas">
    <ul class="pagination pagination-sm justify-content-center mb-0" style="gap: 3px;">

        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link" style="border-radius: 6px;">
                    <i class="fas fa-chevron-left fa-xs"></i> Anterior
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="border-radius: 6px;">
                    <i class="fas fa-chevron-left fa-xs"></i> Anterior
                </a>
            </li>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link" style="border-radius: 6px;">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link" style="border-radius: 6px; font-weight: 600;">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}" style="border-radius: 6px;">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Próximo --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="border-radius: 6px;">
                    Próximo <i class="fas fa-chevron-right fa-xs"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link" style="border-radius: 6px;">
                    Próximo <i class="fas fa-chevron-right fa-xs"></i>
                </span>
            </li>
        @endif

    </ul>
</nav>
@endif

<style>
    .pagination .page-item.active .page-link {
        background-color: #297ee9 !important;
        border-color: #297ee9 !important;
        color: #fff !important;
    }
    .pagination .page-item .page-link {
        color: #297ee9;
    }
    .pagination .page-item .page-link:hover {
        color: #297ee9;
        background-color: #e8f0fe;
        border-color: #dee2e6;
    }
</style>