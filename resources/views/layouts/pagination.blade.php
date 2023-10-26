<ul class="pagination">
    @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <span class="page-link">Trang trước</span>
        </li>
    @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Trang trước</a>
        </li>
    @endif
    @foreach ($elements as $element)
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Trang kế tiếp</a>
        </li>
    @else
        <li class="page-item disabled">
            <span class="page-link">Trang kế tiếp</span>
        </li>
    @endif
</ul>
