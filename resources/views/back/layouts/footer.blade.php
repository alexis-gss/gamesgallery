<footer id="footer" class="text-center text-secondary px-0">
    <div class="text-center p-2">
        <a href="https://github.com/alexis-gss/gamesgallery"
            target="_blank"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('footer.website') }}"
            class="text-reset text-decoration-none">
            {{ $name }}
        </a>
        - v2.1 -
        <span class="text-reset">
            {{ config('app.name') }}
        </span>
        © {{ date('Y') }}
    </div>
</footer>
