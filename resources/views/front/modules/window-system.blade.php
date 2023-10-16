<script @if(isset($nonce)) nonce="{{ $nonce }}" @endif>
    if (!window.__SYSTEM) {
        window.__SYSTEM = {};
    }
    window.__SYSTEM._locale = '{{ app()->getLocale() }}';
    window.__SYSTEM._translations = @json(cache(sprintf('translations.%s', app()->getLocale())) ?? []);
    if(!window.__SYSTEM._routes) {
        window.__SYSTEM._routes = {}
    }
    window.__SYSTEM._routes.fo = {
        games: {
            show: "{{ route('fo.games.show', ['slug' => 'SLUG']) }}",
            filtered: "{{ route('fo.games.filtered', ['filtersId' => 'FILTERSID']) }}",
        },
    };
</script>
