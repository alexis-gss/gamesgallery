<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('form.identification') }}</b>
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_name_game') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
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
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_folders', ['number' => count($globalFolders)]) }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
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
            <legend>{{ __('form.visuals') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="pictures" class="col-form-label">
                        <b>{{ __('form.images') }}</b>
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_game_images') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </label>
                    <input type="file"
                        id="pictures"
                        name="pictures[]"
                        accept="image/jpg"
                        class="form-control mb-1"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.tooltip_game_images') }}" multiple>
                    <small class="text-muted">{{ __('form.images_label', [
                            'format' => Config::get('images.format'),
                            'width' => Config::get('images.maxwidth'),
                            'height' => Config::get('images.maxheight'),
                        ]) }}
                    </small>
                </div>
                @if ($game->pictures !== null && count($game->pictures) > 0)
                    <div class="col-12 col-md-6 form-group">
                        <label class="col-form-label"><b>{{ __('form.images_result') }}</b></label>
                            <div class="preview position-relative">
                                @foreach ($game->pictures as $key => $pictures)
                                    @if ($key > 4)
                                        @break
                                    @else
                                        <img src="{{ asset($pictures) }}" alt="{{ $game->pictures_alt }}" style="max-height: 100px;">
                                    @endif
                                @endforeach
                            <div class="filtre position-absolute h-100"></div>
                        </div>
                        <small class="text-muted">
                            {{ __('form.actual_images', ['number' => $game->pictures !== null ? count($game->pictures) : 0]) }}
                        </small>
                        @include('back.modules.input-error', ['inputName' => 'picture'])
                    </div>
                @endif
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
                        <input class="form-check-input" name="status" type="checkbox" value="1" id="flexSwitchCheckDefault" @if (old('status', $game->status ?? '')) checked @endif>
                        <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('form.publish') }}</label>
                    </div>
                    <br>
                    @include('back.modules.input-error', ['inputName' => 'status'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
