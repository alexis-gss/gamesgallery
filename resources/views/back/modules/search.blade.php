@if (count($target) > 1 || Route::is($routeSearch))
    <form action="{{ route($routeSearch) }}" method="GET" enctype="multipart/form-data" id="filter"
        class="d-flex flex-row input-group pt-3">
        <input class="form-control" type="text" data-bs="tooltip" data-bs-placement="top"
            title="{{ __('filter.search_game') }}" placeholder="{{ __('filter.search_game') }}" id="filter"
            name="filter" value="{{ old('filter', $filter ?? '') }}" required>
        <button class="btn btn-primary" type="submit" data-bs="tooltip" data-bs-placement="top"
            title="{{ __('filter.apply_filter') }}">
            <svg width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 512 512">
                <path
                    d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z" />
            </svg>
        </button>
        <a class="btn btn-danger" data-bs="tooltip" data-bs-placement="top" title="{{ __('filter.remove_filter') }}"
            href="{{ route($routeIndex) }}">
            <svg width="16" height="16" fill="currentColor" class="bi bi-backspace-fill" viewBox="0 0 576 512">
                <path
                    d="M576 384C576 419.3 547.3 448 512 448H205.3C188.3 448 172 441.3 160 429.3L9.372 278.6C3.371 272.6 0 264.5 0 256C0 247.5 3.372 239.4 9.372 233.4L160 82.75C172 70.74 188.3 64 205.3 64H512C547.3 64 576 92.65 576 128V384zM271 208.1L318.1 256L271 303C261.7 312.4 261.7 327.6 271 336.1C280.4 346.3 295.6 346.3 304.1 336.1L352 289.9L399 336.1C408.4 346.3 423.6 346.3 432.1 336.1C442.3 327.6 442.3 312.4 432.1 303L385.9 256L432.1 208.1C442.3 199.6 442.3 184.4 432.1 175C423.6 165.7 408.4 165.7 399 175L352 222.1L304.1 175C295.6 165.7 280.4 165.7 271 175C261.7 184.4 261.7 199.6 271 208.1V208.1z" />
            </svg>
        </a>
    </form>
@endif
