

@if ($paginator->hasPages() && !($paginator->onLastPage()))
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}

        @if ($paginator->onFirstPage())
        <span id = "prevBtn">
            {!! __('pagination.previous') !!}
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" id = "prevBtn" >
            {!! __('pagination.previous') !!}
        </a>
    @endif

        {{-- Next Page Link --}}

    </nav>
    @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" id="nextBtn">

                {!! __('pagination.next') !!}
            </a>
            @else
            <a id="nextBtn">
                {!! __('Finish') !!}
            </a>
        @endif
@endif
