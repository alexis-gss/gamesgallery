<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.organization') }}</b></label>
                    <select class="form-select" id="folder_id" name="folder_id" data-bs="tooltip" data-bs-placement="top"
                        title="{{ __('form.select_folder') }}" role="button">
                        <option value="" @if (isset($game->folder_id)) selected @endif>
                            {{ __('form.no_associated_folder') }}
                        </option>
                        @foreach ($globalFolders as $folder)
                            <option value="{{ $folder->id }}" @if ($folder->id === $game->folder_id) selected @endif>
                                {{ $folder->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">{{ __('form.folder_associated') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'folder_id'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.identification') }}</b></label>
                    <input type="text" id="name" name="name" class="form-control"
                        placeholder="{{ __('form.type_name_game') }}*" value="{{ old('name', $game->name ?? '') }}"
                        data-bs="tooltip" data-bs-placement="top" title="{{ __('form.type_name_game') }}" required>
                    <small class="text-muted">{{ __('form.name') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
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
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.images') }}</b></label>
                    <input type="file" id="pictures" name="pictures[]" accept="image/jpg" class="form-control mb-1"
                        data-bs="tooltip" data-bs-placement="top" title="{{ __('form.select_images') }}" multiple>
                    <small class="text-muted">{{ __('form.format') }} : {{ Config::get('images.format') }} -
                        {{ __('form.dimensions_max') }} :
                        {{ Config::get('images.maxwidth') }}/{{ Config::get('images.maxheight') }}px</small>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label"><b>{{ __('form.preview') }}</b></label>
                    <div class="preview w-fit position-relative">
                        @if ($game->pictures !== null && count($game->pictures) > 0)
                            <img src="{{ asset($game->pictures[0]) }}" alt="{{ $game->pictures_alt }}"
                                style="max-height: 100px;">
                            <div class="filtre position-absolute h-100"></div>
                        @else
                            <p class="m-0">
                                {{ __('form.no_related_images') }}
                            </p>
                        @endif
                    </div>
                    @include('back.modules.input-error', ['inputName' => 'picture'])
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
