<div class="btn-lang d-none d-lg-block position-fixed bg-secondary rounded-2 p-2">
    <button class="btn btn-primary nav-link dropdown-toggle bg-primary d-flex align-items-center h-100 flex-row border-0 p-3"
        data-bs-toggle="dropdown" type="button" aria-expanded="false">
        <i class="fa-solid text-white fa-globe"></i>
    </button>
    <form class="dropdown-menu dropdown-menu-custom dropdown-menu-start bg-secondary text-center"
        id="lang-selector"
        action="{{ route('fo.lang.set') }}"
        method="POST">
        @push('scripts')
            <script @if (!empty($nonce)) nonce="{{ $nonce }}" @endif>
                document.addEventListener('DOMContentLoaded', function() {
                    const langSelector = document.getElementById('lang-selector');
                    if (langSelector) {
                        langSelector.addEventListener('change', function() {
                            this.submit();
                        });
                    }
                });
            </script>
        @endpush
        @csrf
        @foreach(config('app.locales') as $key => $locale)
        <input type="radio" class="btn-check" name="lang" id="lang{{ $key }}" value="{{ $locale }}">
        <label class="dropdown-item btn btn-secondary @if ($locale === app()->getLocale()) active @endif" for="lang{{ $key }}">
            {{ Str::of($locale)->upper() }}
        </label>
        @endforeach
    </form>
</div>