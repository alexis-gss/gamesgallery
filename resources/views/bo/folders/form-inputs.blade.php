<div>
    <p class="fs-2 fw-bold mt-2 mb-0">{{ __('Identification') }}</p>
</div>
<div class="form-group">
    <label for="name">{{ __('Name') }} *</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="{{ __('Type_name_folder') }} *"
        value="{{ old('name', $folder->name ?? '') }}" title="{{ __('Type_name_folder') }}" required>
    @include('bo.modules.input-error', ['inputName' => 'name'])
</div>
