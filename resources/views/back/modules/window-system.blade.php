<script @if(isset($nonce)) nonce="{{ $nonce }}" @endif>
    if (!window.__SYSTEM) {
        window.__SYSTEM = {};
    }
    window.__SYSTEM._locale = '{{ app()->getLocale() }}';
    window.__SYSTEM._translations = @json(cache(sprintf('translations.%s', app()->getLocale())) ?? []);
    if(!window.__SYSTEM._routes) {
        window.__SYSTEM._routes = {}
    }
    window.__SYSTEM._routes.bo = {
        tags: {
            store: '{{ route('bo.tags.store') }}',
            jsonStore: '{{ route('bo.tags.jsonStore') }}'
        }
    };
</script>
@stack('scripts')
