<div class="row">
    <div class="col">
        <fieldset class="p-3 mb-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="name" class="col-form-label"><b>{{ __('form.identification') }}</b></label>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control w-22"
                        placeholder="{{ __('form.type_name_folder') }}*"
                        value="{{ old('name', $folder->name ?? '') }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.type_name_folder') }}">
                    <small class="text-muted">{{ __('form.name') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
