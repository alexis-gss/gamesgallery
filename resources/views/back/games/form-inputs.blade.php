<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('form.identification') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('form.tooltip_name_game') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control need-word-counter"
                        placeholder="{{ __('form.name') }}"
                        value="{{ old('name', $game->name ?? '') }}">
                    <small class="text-muted">{{ __('form.name_label') }}</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('form.organization') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('form.tooltip_folders', ['number' => count($globalFolders)]) }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    @include('back.modules.select-folder', ['type' => 'folder_id', 'target' => $game->folder_id])
                    <small class="text-muted">{{ __('form.folders_label') }}</small>
                    @include('back.modules.input-error', ['inputName' => 'folder_id'])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('Visuals') }}</legend>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="name" class="col-form-label">
                        <b>{{ __('form.images') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('form.tooltip_game_images') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    @php
                        $data = [
                            'id' => 'gamePictures',
                            'name' => 'game_pictures[]',
                            'width' => 396,
                            'height' => 286,
                            'value' => $game->pictures ?? [],
                            'limit' => [0,100],
                            'errors' => $errors->getBag('default')->getMessages()
                        ];
                    @endphp
                    <div class="images-input" data-json='@json($data)'></div>
                    @include('back.modules.input-error', [
                        'inputName' => 'game_pictures[]',
                        'helper' => __('Les images du jeu doivent être de 396px (largeur) par 286px (hauteur),
                            (minimum 0 et maximum 100 images sont autorisées).')
                    ])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="name" class="col-form-label">
                        <b>{{ __('form.tags') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('form.tooltip_tags', ['number' => count($globalTags)]) }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    @php
                        $data = [
                            'name' => 'tags',
                            'value' => old('tags', $game->tags ?? []),
                            'tags' => $tags,
                        ];
                    @endphp
                    <div id="taggable-dropdown" data-json='@json($data)'></div>
                    @include('back.modules.input-error', ['inputName' => 'tags'])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.visibility') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-check form-switch">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                            name="status"
                            type="checkbox"
                            value="1"
                            id="flexSwitchCheckDefault"
                            @if (old('status', $game->status ?? '')) checked @endif
                            role="button">
                        <label class="form-check-label" for="flexSwitchCheckDefault" role="button">{{ __('form.publish') }}</label>
                    </div>
                    <br>
                    @include('back.modules.input-error', ['inputName' => 'status'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
