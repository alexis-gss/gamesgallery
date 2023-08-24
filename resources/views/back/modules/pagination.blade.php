{{-- GET ACTUAL PAGINATION --}}
<?php $pagination = intval(Cache::get('pagination-' . \Illuminate\Support\Str::slug(request()->route()->getName()))); ?>
@if($paginator->items())
<nav class="pagination-custom d-flex flex-column flex-md-row justify-content-between align-items-center">
    {{-- SELECT ITEMS PER PAGE --}}
    <div class="dropup-center dropup d-flex justify-content-center align-items-center w-fit input-group mb-3 m-md-0">
        <span class="btn-md input-group-text"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('crud.pagination.paginate_list') }}">
            <i class="fa-solid fa-list-ul"></i>
        </span>
        <button class="btn btn-primary dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ $pagination }}
        </button>
        <ul class="dropdown-menu">
            @foreach (\App\Enums\Pagination\ItemsPerPaginationEnum::toArray() as $itemsPerPaginationEnum)
            <li>
                <a class="dropdown-item text-center user-select-none @if($pagination === $itemsPerPaginationEnum->value) active @endif"
                    href="{{ request()->fullUrlWithQuery(['page' => 1, 'pagination' => $itemsPerPaginationEnum->value]) }}"
                    role="button">
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
                    title="{{ __('crud.pagination.previous') }}"
                    @if (!$paginator->onFirstPage())
                    href="{{ request()->fullUrlWithQuery(['page' => $paginator->currentPage() - 1]) }}"
                    @endif
                    rel="prev"
                    aria-label="@lang('crud.pagination.previous')"
                    @if ($paginator->onFirstPage()) aria-hidden="true" disabled @endif>
                    <i class="fa-solid fa-chevron-left fa-2xs mt-1"></i>
                </a>
            </li>
            {{-- FIRST PAGE --}}
            @if($paginator->currentPage() > 3)
            <li class="page-item"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('crud.pagination.specific_page', ['id' => 1]) }}">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">1</a>
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
                            <a class="dropdown-item text-center user-select-none @if($paginator->currentPage() === $i) active @endif"
                                href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                                role="button">
                                {{ $i }}
                            </a>
                        </li>
                        @endfor
                    </ul>
                </div>
            </li>
            @else
            <li class="page-item d-none d-sm-block"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('crud.pagination.specific_page', ['id' => $i]) }}">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
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
                title="{{ __('crud.pagination.specific_page', ['id' => $paginator->lastPage()]) }}">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $paginator->lastPage()]) }}">{{ $paginator->lastPage() }}</a>
            </li>
            @endif
            {{-- NEXT PAGE --}}
            <li class="page-item @if (!$paginator->hasMorePages()) disabled @endif">
                <a class="page-link d-flex align-items-center h-100"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.pagination.next') }}"
                    @if ($paginator->hasMorePages())
                    href="{{ request()->fullUrlWithQuery(['page' => $paginator->currentPage() + 1]) }}"
                    @endif
                    rel="next"
                    aria-label="{{ __('crud.pagination.next') }}"
                    @if (!$paginator->hasMorePages()) aria-hidden="true" disabled @endif>
                    <i class="fa-solid fa-chevron-right fa-2xs mt-1"></i></a>
            </li>
        </ul>
    </div>
    @endif
</nav>
@endif
