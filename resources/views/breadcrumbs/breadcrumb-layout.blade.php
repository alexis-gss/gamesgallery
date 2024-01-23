@if (count($breadcrumbs))
    <ol
        class="breadcrumb @if (!Request::is('bo/*')) border border-top-0 border-bottom-0 border-end-0 border-secondary w-100 m-0 @else m-0 @endif flex-nowrap">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item d-flex">
                    <a class="text-decoration-none @if (!Request::is('bo/*')) p-3 pe-0 text-white @else h2 ps-2 m-0 fw-bold @endif"
                        href="{{ $breadcrumb->url }}">
                        {{ $breadcrumb->title }}
                    </a>
                </li>
            @else
                <li
                    class="breadcrumb-item btn-games d-flex align-items-center flex-grow-1 active @if (Request::is('bo/*')) h2 m-0 fw-bold @else text-white @endif">
                    {{ $breadcrumb->title }}
                </li>
            @endif
        @endforeach
    </ol>
@endif
