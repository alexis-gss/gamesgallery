<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.identification') }}</b></label>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="{{ __('form.type_name_game') }}*"
                        value="{{ old('name', $game->name ?? '') }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.type_name_game') }}">
                    <small class="text-muted">{{ __('form.name') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.organization') }}</b></label>
                    @include('back.modules.select-folder', ['type' => 'folder_id', 'target' => $game->folder_id])
                    <small class="text-muted">{{ __('form.folder_associated') }}</small>
                    @include('back.modules.input-error', ['inputName' => 'folder_id'])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.visuals') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="pictures" class="col-form-label"><b>{{ __('form.images') }}</b></label>
                    <input type="file"
                        id="pictures"
                        name="pictures[]"
                        accept="image/jpg"
                        class="form-control mb-1"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.select_images') }}" multiple>
                    <small
                        class="text-muted">{{ __('form.images_rules', [
                            'format' => Config::get('images.format'),
                            'width' => Config::get('images.maxwidth'),
                            'height' => Config::get('images.maxheight'),
                        ]) }}
                    </small>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label"><b>{{ __('form.preview') }}</b></label>
                    @if ($game->pictures !== null && count($game->pictures) > 0)
                        <div class="preview position-relative">
                            @foreach ($game->pictures as $key => $pictures)
                                @if ($key > 4)
                                    @break
                                @else
                                    <img src="{{ asset($pictures) }}" alt="{{ $game->pictures_alt }}"
                                        style="max-height: 100px;">
                                @endif
                            @endforeach
                        <div class="filtre position-absolute h-100"></div>
                    </div>
                    <small
                        class="text-muted">{{ __('form.actual_images', ['number' => $game->pictures !== null ? count($game->pictures) : 0]) }}</small>
                    @else
                        <p class="m-0">{{ __('form.no_related_images') }}</p>
                    @endif
                    @include('back.modules.input-error', ['inputName' => 'picture'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
