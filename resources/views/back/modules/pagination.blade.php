<nav class="pagination-custom d-flex justify-content-between align-items-center">
    {{-- SELECT ITEMS PER PAGE --}}
    <div class="dropup-center dropup d-flex justify-content-center align-items-center w-fit input-group">
        <span class="btn-md input-group-text" title="{{ __('pagination.paginate_list') }}" data-bs="tooltip">
            <i class="fa-solid fa-list-ul"></i>
        </span>
        <button class="btn btn-primary dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ (Cache::get('pagination')) ? intval(Cache::get('pagination')) : config('pagination.default') }}
        </button>
        <ul class="dropdown-menu">
            @foreach (\App\Enums\Pagination\ItemsPerPaginationEnum::toArray() as $itemsPerPaginationEnum)
            <li>
                <a class="dropdown-item text-center"
                    href="{{ request()->fullUrlWithQuery(['pagination' => $itemsPerPaginationEnum->value]) }}">
                    {{ $itemsPerPaginationEnum->value }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @if ($paginator->hasPages())
    {{-- PAGINATION --}}
    <div class="d-flex justify-content-end align-items-center">
        <ul class="pagination m-0">
            {{-- PREVIOUS PAGE --}}
            <li class="page-item @if ($paginator->onFirstPage()) disabled @endif">
                <a class="page-link d-flex align-items-center h-100"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('pagination.previous') }}"
                    @if (!$paginator->onFirstPage()) href="{{ $paginator->previousPageUrl() }}" @endif rel="prev"
                    aria-label="@lang('pagination.previous')"
                    @if ($paginator->onFirstPage()) aria-hidden="true" @endif>
                    <i class="fa-solid fa-chevron-left fa-2xs mt-1"></i>
                </a>
            </li>
            {{-- FIRST PAGE --}}
            @if($paginator->currentPage() > 3)
            <li class="page-item"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('pagination.specific_page', ['id' => 1]) }}">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
            @endif
            {{-- HIDE PAGES TOO FAR --}}
            @if($paginator->currentPage() > 4)
            <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            {{-- SHOW ACTUAL PAGES + N-2/N+2 --}}
            @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
            @if ($i == $paginator->currentPage())
            <li class="page-item">
                <div class="dropup-center dropup">
                    <button class="btn btn-primary dropdown-toggle rounded-0"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ $i }}
                    </button>
                    <ul class="dropdown-menu">
                        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        <li>
                            <a class="dropdown-item text-center" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">
                                {{ $i }}
                            </a>
                        </li>
                        @endfor
                    </ul>
                </div>
            </li>
            @else
            <li class="page-item"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('pagination.specific_page', ['id' => $i]) }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
            @endif
            @endif
            @endforeach
            {{-- HIDE PAGES TOO FAR --}}
            @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            {{-- LAST PAGE --}}
            @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('pagination.specific_page', ['id' => $paginator->lastPage()]) }}">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            </li>
            @endif
            {{-- NEXT PAGE --}}
            <li class="page-item @if (!$paginator->hasMorePages()) disabled @endif">
                <a class="page-link d-flex align-items-center h-100"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('pagination.next') }}"
                    @if ($paginator->hasMorePages()) href="{{ $paginator->nextPageUrl() }}" @endif rel="next"
                    aria-label="@lang('pagination.next')"
                    @if (!$paginator->hasMorePages()) aria-hidden="true" @endif>
                    <i class="fa-solid fa-chevron-right fa-2xs mt-1"></i></a>
            </li>
        </ul>
    </div>
    @endif
</nav>
