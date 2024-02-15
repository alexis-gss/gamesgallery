<div class="toast-container position-fixed end-0 top-0 p-3">
    {{-- TOASTS TEMPLATE --}}
    <div class="toast text-bg-secondary fade hide border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">
                <span class="badge rounded-2 m-0 px-2 py-0 text-white"></span>
                <span class="toast-action">Like ajouté</span>
            </strong>
            <small class="text-body-secondary">{{ __('fo_toast_time') }}</small>
            <button class="btn-close" data-bs-dismiss="toast" type="button" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ __('fo_toast_message_part1') }} <span class="toast-action-detail">d'ajouter</span> {{ __('fo_toast_message_part2') }}
            <i class="fa-solid fa-thumbs-up mx-1"></i> {{ __('fo_toast_message_part3') }}
            <strong>n°<span class="toast-picture-id">0</span></strong> {{ __('fo_toast_message_part4') }} <strong
                class="toast-game-name">test</strong>.
        </div>
    </div>
</div>
