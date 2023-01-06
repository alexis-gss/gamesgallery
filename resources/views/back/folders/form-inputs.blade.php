<div class="row">
    <div class="col">
        <fieldset class="p-3 mb-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="name" class="col-form-label">
                        <b>{{ __('form.identification') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('form.tooltip_name_folder') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control need-word-counter"
                        placeholder="{{ __('form.name') }}*"
                        value="{{ old('name', $folder->name ?? '') }}">
                    <small class="text-muted">{{ __('form.name_label') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
