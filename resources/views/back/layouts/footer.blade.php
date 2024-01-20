<footer id="footer" class="bg-body-tertiary px-0 text-center">
    <div class="text-center p-2">
        @if (isset($globalLicense))
        <span>{{ $globalLicense }}</span>
        <span>-</span>
        @endif
        @if (isset($globalName))
        <a href="https://github.com/alexis-gss/games-gallery"
            target="_blank"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('global_acces_github') }}"
            class="text-reset text-decoration-none">
            {{ $globalName }}
        </a>
        <span>-</span>
        @endif
        @if (isset($globalVersion))
        v{{ $globalVersion }}&nbsp;<span>-</span>
        @endif
        <span class="text-reset">{{ config('app.name') }}</span>
        <span>©&nbsp;{{ date('Y') }}</span>
    </div>
</footer>
