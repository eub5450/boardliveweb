@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $startPage = max(1, $currentPage - 1);
        $endPage = min($lastPage, $currentPage + 1);
    @endphp
    <div class="pagination">
        <div class="pagination-meta">
            Page {{ $currentPage }} of {{ $lastPage }}.
            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} rows.
        </div>
        <div class="pagination-links">
            @if ($paginator->onFirstPage())
                <span class="page-link disabled">Previous</span>
            @else
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
            @endif

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page === $currentPage)
                    <span class="page-link active">{{ $page }}</span>
                @else
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                @endif
            @endfor

            @if ($paginator->hasMorePages())
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
            @else
                <span class="page-link disabled">Next</span>
            @endif
        </div>
    </div>
@endif