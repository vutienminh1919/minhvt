@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- First Page Link --}}
            @if (!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="First Page">&laquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                       aria-label="Previous Page">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        {{-- Hiển thị trang đầu, cuối, xung quanh trang hiện tại --}}
                        @if (
                            $page == 1 ||
                            $page == $paginator->lastPage() ||
                            ($page >= $paginator->currentPage() - 1 && $page <= $paginator->currentPage() + 1)
                        )
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @elseif ($page == 2 || $page == $paginator->lastPage() - 1)
                            {{-- Hiển thị dấu ... --}}
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next Page">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&rsaquo;</span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Last Page">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            @endif
        </ul>
        {{-- Jump to Page Input --}}
        <form action="" method="GET" class="d-inline">
            <div class="input-group" style="max-width: 100px;">
                <input type="number" name="page" class="form-control" min="0" max="{{ $paginator->lastPage() }}"
                       placeholder="Nhập số trang" value="0">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Đi</button>
                </div>
            </div>
        </form>
    </nav>
@endif
