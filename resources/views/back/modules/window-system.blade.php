<script @if (isset($nonce)) nonce="{{ $nonce }}" @endif>
    if (!window.__SYSTEM) {
        window.__SYSTEM = {};
    }
    window.__SYSTEM._locale = "{{ app()->getLocale() }}";
    window.__SYSTEM._translations = @json(cache(sprintf('translations.%s', app()->getLocale())) ?? []);
    if (!window.__SYSTEM._routes) {
        window.__SYSTEM._routes = {}
    }
    window.__SYSTEM._routes = {
        fo: {
            games: {
                show: "{{ route('fo.games.show', ['slug' => 'SLUG']) }}",
            },
        },
        bo: {
            tags: {
                store: "{{ route('bo.tags.store') }}",
                jsonStore: "{{ route('bo.tags.jsonStore') }}",
            },
            games: {
                show: "{{ route('fo.games.show', 'ID') }}",
                edit: "{{ route('bo.games.edit', 'ID') }}",
                upload: "{{ route('bo.games.upload') }}",
            },
            ranks: {
                games: "{{ route('bo.ranks.games') }}",
                saveOrder: "{{ route('bo.ranks.save-order', 'RANKS') }}",
                destroy: "{{ route('bo.ranks.destroy', 'ID') }}",
            },
        }
    }
</script>
@stack('scripts')
