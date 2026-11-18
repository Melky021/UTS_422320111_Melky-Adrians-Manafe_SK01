@if ($paginator->hasPages())
    <nav class="pager" aria-label="Navigasi halaman">
        @if ($paginator->onFirstPage())
            <span class="pager-item disabled">&lsaquo; Sebelumnya</span>
        @else
            <a class="pager-item" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo; Sebelumnya</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pager-item disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pager-item active">{{ $page }}</span>
                    @else
                        <a class="pager-item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="pager-item" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya &rsaquo;</a>
        @else
            <span class="pager-item disabled">Berikutnya &rsaquo;</span>
        @endif
    </nav>
@endif
