<p class="fs-5 fw-semibold mb-4 text-center">
    {{ str(__('models.rating'))->ucFirst()->value() .
        "\u{00A0}" .
        __('bo_other_stats_by') .
        "\u{00A0}" .
        str(__('models.picture'))->ucFirst()->value() }}
</p>
<ul class="list-group border-0">
    @foreach ($picturesRatings as $key => $pictureRating)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <button class="btn btn-primary btn-sm" data-bs-tooltip="tooltip" data-bs-toggle="modal" data-bs-target="#ModalViewPicture"
                type="button" title="{{ __('crud.actions_model.show', ['model' => __('models.picture')]) }}">
                {{ __('bo_other_stats_picture_id', [
                    'id' => $pictureRating->picture->id,
                    'game' => $pictureRating->picture->game->name,
                ]) }}
            </button>
            <span class="badge rounded-pill bg-secondary">{{ $pictureRating->ratings_count }}</span>
            <div class="modal" id="ModalViewPicture" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" tabindex="-1">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {{ str(__('models.picture'))->ucFirst()->value() }}
                                </h5>
                                <button class="btn-close" data-bs-dismiss="modal" data-bs-tooltip="tooltip" type="button"
                                    aria-label="{{ __('bo_other_close') }}" :title="__('bo_other_close')" />
                            </div>
                            <div class="modal-body">
                                <img class="img-fluid"
                                    src="{{ sprintf('%s/storage/pictures/%s/%s.webp', config('app.url'), $pictureRating->picture->game->slug, $pictureRating->picture->uuid) }}"
                                    alt="{{ $pictureRating->picture->label }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
