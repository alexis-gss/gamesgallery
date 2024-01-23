<footer class="@if (request()->routeIs('fo.games.index')) footer-home m-0 @else footer-page mt-5 @endif text-center">
    <p class="m-0">
        <span>© {{ date('Y') }}</span>
        <a class="text-third text-decoration-none" data-bs-tooltip="tooltip" data-bs-placement="top" href="https://www.alexis-gousseau.com"
            title="{{ __('bo_other_access_website') }}" target="_blank">
            Alexis Gousseau
        </a>
        <span>| All rights reserved</span>
    </p>
</footer>
