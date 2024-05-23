<p class="fs-5 fw-semibold mb-4 text-center">
    {{ str(__('models.rating'))->ucFirst()->value() .
        "\u{00A0}" .
        __('bo_other_stats_by') .
        "\u{00A0}" .
        str(__('models.picture'))->ucFirst()->value() }}
</p>
<ul class="list-group border-0">
    @foreach ($picturesRatings as $key => $pictureRating)
        @php $pictureExist = Storage::disk("public")->exists(sprintf("pictures/%s/%s.webp", $pictureRating->picture->game->slug, $pictureRating->picture->uuid)) @endphp
        <li class="list-group-item d-flex justify-content-between align-items-center">
            @if ($pictureExist)
                <button class="btn btn-primary btn-sm" data-bs-tooltip="tooltip" data-bs-toggle="modal"
                    data-bs-target="#ModalViewPicture{{ $key }}" type="button"
                    title="{{ __('crud.actions_model.show', ['model' => __('models.picture')]) }}">
            @else
                <p class="m-0">
            @endif
                {{ __('bo_other_stats_picture_id', [
                    'id' => $pictureRating->picture->id,
                    'game' => $pictureRating->picture->game->name,
                ]) }}
            @if ($pictureExist)
                </button>
            @else
                </p>
            @endif
            <span class="badge rounded-pill text-bg-secondary">{{ $pictureRating->ratings_count }}</span>
            @if ($pictureExist)
                @include('back.partials.modal-view-picture', [
                    'id' => "ModalViewPicture$key",
                    'pictureSrc' => sprintf(
                        '%s/storage/pictures/%s/%s.webp',
                        config('app.url'),
                        $pictureRating->picture->game->slug,
                        $pictureRating->picture->uuid),
                    'pictureAlt' => $pictureRating->picture->label,
                    'pictureTitle' => str(__('models.picture'))->ucFirst(),
                ])
            @endif
        </li>
    @endforeach
</ul>
