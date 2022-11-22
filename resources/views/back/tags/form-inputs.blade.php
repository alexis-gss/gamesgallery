<div class="row">
    <div class="col">
        <fieldset class="p-3 mb-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="name" class="col-form-label">
                        <b>{{ __('form.identification') }}</b>
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_name_tag') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control need-word-counter"
                        placeholder="{{ __('form.name') }}*"
                        value="{{ old('name', $tag->name ?? '') }}">
                    <small class="text-muted">{{ __('form.name_label') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
