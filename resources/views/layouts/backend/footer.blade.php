<footer id="footer" class="position-absolute fixed-bottom text-center text-secondary bg-light px-0">
    <div class="text-center p-2">
        <a href="https://github.com/alexis-gss/gamesgallery" target="_blank"
            class="text-reset text-decoration-none">{{ $name }}</a>
        -
        v{{ $version }}
        -
        <span class="text-reset">{{ config('app.name') }}</span>
        © {{ date('Y') }}
    </div>
</footer>
