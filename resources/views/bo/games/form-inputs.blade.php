<div>
    <p class="fw-bold mt-2 mb-0">{{ __('form.organization') }}</p>
</div>

<div class="form-group d-flex flex-column">
    <label for="folder_id">{{ __('form.folder_associated') }}</label>
    <select class="form-select w-fit" id="folder_id" name="folder_id" title="{{ __('form.select_folder') }}" role="button">
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
    <p class="fw-bold mt-2 mb-0">{{ __('form.identification') }}</p>
</div>
<div class="form-group">
    <label for="name">{{ __('form.name') }}*</label>
    <input type="text" id="name" name="name" class="form-control w-22"
        placeholder="{{ __('form.type_name_game') }}*" value="{{ old('name', $game->name ?? '') }}"
        title="{{ __('form.type_name_game') }}" required>
    @include('bo.modules.input-error', ['inputName' => 'name'])
</div>

<div>
    <p class="fw-bold mt-2 mb-0">{{ __('form.visuals') }}</p>
</div>
<div class="form-group">
    <label for="pictures">{{ __('form.images') }}
        <small class="text-muted"> - JPG</small>
    </label>
    <input type="file" id="pictures" name="pictures[]" accept="image/jpg" class="form-control mb-1 w-22"
        title="{{ __('form.select_images') }}" multiple>
    <div class="preview w-fit position-relative">
        @if ($game->pictures !== null)
            @foreach ($game->pictures as $key => $picture)
                @if ($key < 4)
                    <img src="{{ asset($picture) }}" alt="{{ $game->pictures_alt }}" style="max-height: 100px;">
                @else
                    <div class="filtre position-absolute h-100"></div>
                    <?php break; ?>
                @endif
            @endforeach
        @else
            {{ __('form.no_related_images') }}
        @endif
    </div>
    @include('bo.modules.input-error', ['inputName' => 'picture'])
</div>
