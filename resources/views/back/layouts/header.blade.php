<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm position-fixed fixed-top">
    <div class="container">
        <a class="navbar-brand"
            href="{{ route('homepage') }}"
            target="_blank"
            data-bs="tooltip"
            data-bs-placement="bottom"
            title="{{ __('nav.access_website') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        @auth
            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        @endauth

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @include('back.layouts.nav-menu')

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @auth
                    <li class="nav-item dropdown">
                        <button class="btn nav-link dropdown-toggle border-0 d-flex flex-row align-items-center"
                            id="navbarDropdown"
                            role="button"
                            data-bs-toggle="dropdown">
                            <div class="profile-picture me-2">
                                <img class="w-100 h-100 rounded-circle" src="{{ asset(Auth::user()->picture) }}" alt="{{ Auth::user()->picture_alt }}">
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end text-center p-0" aria-labelledby="navbarDropdown">
                            <a class="btn btn-link w-100 h-100 text-decoration-none text-muted p-2"
                                href="{{ route('bo.users.edit', Auth::user()->id) }}"
                                title="{{ __('nav.to_edit_profile') }}"
                                data-bs="tooltip"
                                data-bs-placement="bottom">{{ __('nav.edit_profile') }}</a>
                            <hr class="dropdown-divider m-0">
                            <form id="logout-form" action="{{ route('bo.logout') }}" method="POST" class="text-center">
                                @csrf
                                <button class="btn btn-link w-100 h-100 text-decoration-none text-muted p-2"
                                    type="submit"
                                    data-bs="tooltip"
                                    data-bs-placement="top"
                                    title="{{ __('nav.to_disconnect') }}">
                                    {{ __('nav.disconnect') }}
                                </button>
                            </form>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
