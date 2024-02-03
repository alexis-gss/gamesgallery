<div class="toast-container position-fixed end-0 top-0 p-3">
    {{-- TOASTS TEMPLATE --}}
    <div class="toast text-bg-secondary border-0 fade hide" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">
                <span class="badge rounded-2 m-0 px-2 py-0 text-white"></span>
                <span class="toast-action">Like ajouté</span>
            </strong>
            <small class="text-body-secondary">{{ __('fo_toast_time') }}</small>
            <button class="btn-close" data-bs-dismiss="toast" type="button" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Vous venez <span class="toast-action-detail">d'ajouter</span> un <i class="fa-solid fa-thumbs-up mx-1"></i> à la photo
            <strong>n°<span class="toast-picture-id">0</span></strong> du jeu <strong class="toast-game-name">test</strong>.
        </div>
    </div>
</div>
