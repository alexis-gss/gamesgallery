<p class="fs-5 fw-semibold mb-4 text-center">
    {{ Str::of(__('models.rating'))->ucFirst()->value() .
        "\u{00A0}" .
        __('bo_other_stats_by') .
        "\u{00A0}" .
        Str::of(__('models.picture'))->ucFirst()->value() }}
</p>
<ul class="list-group border-0">
    @foreach ($picturesRatings as $key => $pictureRating)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a class="btn btn-primary btn-sm" data-bs-tooltip="tooltip"
                href="{{ sprintf('%s/storage/pictures/%s/%s.webp', config('app.url'), $pictureRating->picture->game->slug, $pictureRating->picture->uuid) }}"
                title="{{ __('crud.actions_model.show', ['model' => __('models.picture')]) }}" target="_blank">
                {{ __('bo_other_stats_picture_id', [
                    'id' => $pictureRating->picture->id,
                    'game' => $pictureRating->picture->game->name,
                ]) }}
            </a>
            <span class="badge bg-secondary rounded-pill">{{ $pictureRating->ratings_count }}</span>
        </li>
    @endforeach
</ul>
