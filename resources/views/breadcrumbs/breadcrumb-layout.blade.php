@if (count($breadcrumbs))
    <ol @class([
        'breadcrumb flex-nowrap',
        'border border-top-0 border-bottom-0 border-end-0 border-secondary w-100 m-0' => !request()->is(
            'bo/*'),
        'm-0' => request()->is('bo/*'),
    ])>
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item d-flex">
                    <a href="{{ $breadcrumb->url }}" @class([
                        'text-decoration-none p-3 pe-0 text-white' => !request()->is('bo/*'),
                        'h2 text-primary ps-2 m-0 fw-bold' => request()->is('bo/*'),
                    ])>
                        {{ $breadcrumb->title }}
                    </a>
                </li>
            @else
                <li @class([
                    'breadcrumb-item btn-games position-relative d-flex align-items-center flex-grow-1 active',
                    'text-white' => !request()->is('bo/*'),
                    'h2 text-body m-0 fw-bold' => request()->is('bo/*'),
                ])>
                    <p @class([
                        'm-0',
                        'breadcrumb-resize position-absolute overflow-hidden text-start' => !request()->is(
                            'bo/*'),
                    ])>
                        {{ $breadcrumb->title }}
                    </p>
                </li>
            @endif
        @endforeach
    </ol>
@endif
