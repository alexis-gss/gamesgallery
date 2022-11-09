<script @if(isset($nonce)) nonce="{{ $nonce }}" @endif>
    if (!window.__SYSTEM) {
        window.__SYSTEM = {};
    }
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
