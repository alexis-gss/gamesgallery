<footer class="@if (Route::is('fo.homepage')) footer-home m-0 @else footer-page mt-5 @endif text-center">
    <p class="m-0">
        <span>© {{ date('Y') }}</span>
        <a href="https://www.alexis-gousseau.com"
            class="text-third text-decoration-none"
            target="_blank"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('texts.bo.other.access_website') }}">
            Alexis Gousseau
        </a>
        | All rights reserved
    </p>
</footer>
