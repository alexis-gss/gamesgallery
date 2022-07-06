<nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('homepage') }}" target="_blank" title="{{ __('Access_website') }}">
            @if (auth()->user()->site ?? false)
                {{ __('Site') }} : <b class="text-primary">{{ ucwords(auth()->user()->site->name) }}</b>
            @else
                {{ config('app.name', 'Laravel') }}
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @auth
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto my-2 my-lg-0 mt-0 mb-0 navbar-nav-scroll px-4"
                    style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <span class="nav-link text-info">{{ __('Role') }} : {{ auth()->user()->role }}</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-success px-0">{{ auth()->user()->name }}</span>
                    </li>
                </ul>
                <form action="{{ route('bo.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary" title="{{ __('To_disconnect') }}">{{ __('Disconnect') }}</button>
                </form>
            </div>
        @endauth
    </div>
</nav>
