@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('pagination.previous') }}"
                    aria-disabled="true"
                    aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('pagination.previous') }}"
                        href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        aria-label="@lang('pagination.previous')">
                        &lsaquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"
                        aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"
                                data-bs="tooltip"
                                data-bs-placement="top"
                                title="{{ __('pagination.current_page') }}"
                                aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link"
                                    data-bs="tooltip"
                                    data-bs-placement="top"
                                    title="{{ __('pagination.specific_page', ['id' => $page]) }}"
                                    href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('pagination.next') }}"
                        href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('pagination.next') }}"
                    aria-disabled="true"
                    aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
