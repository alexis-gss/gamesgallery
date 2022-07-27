<div>
    <p class="fw-bold mt-2 mb-0 px-2">{{ __('form.organization') }}</p>
</div>

<div class="form-group d-flex flex-column">
    <label class="px-2" for="folder_id">{{ __('form.folder_associated') }}</label>
    <select class="form-select w-fit" id="folder_id" name="folder_id" data-bs="tooltip" data-bs-placement="top"
        title="{{ __('form.select_folder') }}" role="button">
        <option value="" @if (isset($game->folder_id)) selected @endif>
            ---- {{ __('form.no_associated_folder') }} ----
        </option>
        @foreach ($folders as $folder)
            <option value="{{ $folder->id }}" @if ($folder->id === $game->folder_id) selected @endif>
                {{ $folder->name }}</option>
        @endforeach
    </select>
    @include('bo.modules.input-error', ['inputName' => 'folder_id'])
</div>

<div>
    <p class="fw-bold mt-2 mb-0 px-2">{{ __('form.identification') }}</p>
</div>
<div class="form-group">
    <label class="px-2" for="name">{{ __('form.name') }}*</label>
    <input type="text" id="name" name="name" class="form-control w-22"
        placeholder="{{ __('form.type_name_game') }}*" value="{{ old('name', $game->name ?? '') }}" data-bs="tooltip"
        data-bs-placement="top" title="{{ __('form.type_name_game') }}" required>
    @include('bo.modules.input-error', ['inputName' => 'name'])
</div>

<div>
    <p class="fw-bold mt-2 mb-0 px-2">{{ __('form.visuals') }}</p>
</div>
<div class="form-group">
    <label class="px-2" for="pictures">{{ __('form.images') }}
        <small class="text-muted"> - {{ __('form.format') }} : {{ Config::get('images.format') }} -
            {{ __('form.dimensions_max') }} :
            {{ Config::get('images.maxwidth') }}/{{ Config::get('images.maxheight') }}px</small>
    </label>
    <input type="file" id="pictures" name="pictures[]" accept="image/jpg" class="form-control mb-1 w-22"
        data-bs="tooltip" data-bs-placement="top" title="{{ __('form.select_images') }}" multiple>
    <div class="preview w-fit position-relative">
        @if ($game->pictures !== null && count($game->pictures) > 0)
            @foreach ($game->pictures as $key => $picture)
                @if ($key < 4)
                    <img src="{{ asset($picture) }}" alt="{{ $game->pictures_alt }}" style="max-height: 100px;">
                @else
                    <div class="filtre position-absolute h-100"></div>
                    <?php break; ?>
                @endif
            @endforeach
        @else
            <p class="px-2 m-0">
                {{ __('form.no_related_images') }}
            </p>
        @endif
    </div>
    @include('bo.modules.input-error', ['inputName' => 'picture'])
</div>
