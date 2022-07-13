<div>
    <p class="fs-4 fw-bold mt-2 mb-0">{{ __('form.identification') }}</p>
</div>
<div class="form-group">
    <label for="name">{{ __('form.name') }}*</label>
    <input type="text" id="name" name="name" class="form-control"
        placeholder="{{ __('form.type_name_folder') }}*" value="{{ old('name', $folder->name ?? '') }}"
        title="{{ __('form.type_name_folder') }}" required>
    @include('bo.modules.input-error', ['inputName' => 'name'])
</div>
