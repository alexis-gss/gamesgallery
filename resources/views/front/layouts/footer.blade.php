<footer @class([
    'text-center',
    'footer-home m-0' => request()->routeIs('fo.games.index'),
    'footer-page mt-5' => !request()->routeIs('fo.games.index'),
])>
    <p class="m-0">
        <span>© {{ date('Y') }}</span>
        <a class="text-third text-decoration-none" data-bs-tooltip="tooltip" data-bs-placement="top" href="https://www.alexis-gousseau.com"
            title="{{ __('bo_other_access_website') }}" target="_blank">
            {{ config('app.conceptor') }}
        </a>
        <span>| All rights reserved</span>
    </p>
</footer>
