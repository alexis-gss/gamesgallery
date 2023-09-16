<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('texts.bo.title.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="name" class="col-form-label">
                        <b>{{ __('texts.bo.label.identification') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.name_folder') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('validation.attributes.name') }}*"
                        value="{{ old('name', $folder->name ?? '') }}">
                    <small class="text-body-secondary">
                        {{ __('validation.between.string', [
                            'attribute' => __('validation.attributes.name'),
                            'min' => 3,
                            'max' => 255
                        ]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="color" class="col-form-label">
                        <b>{{ __('validation.attributes.color') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.color_picker') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <input
                        id="color"
                        name="color"
                        type="text"
                        data-jscolor="{
                            value: '{{ old('color', $folder->color ?? '#0D6EFD') }}',
                            borderColor: 'var(--bs-border-color)',
                            shadow: false,
                            palette:[
                                '#FFFFFF', '#808080', '#000000', '#996e36', '#f55525', '#ffe438', '#88dd20', '#22e0cd', '#269aff', '#bb1cd4'
                            ],
                        }"
                        class="form-control"
                        required>
                    <small class="text-body-secondary">
                        {{ __('validation.custom.color_label') }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'color'])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('texts.bo.title.visibility') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-check form-switch">
                    <div class="form-check form-switch">
                        <input class="form-check-input @error('published') is-invalid @enderror"
                            name="published"
                            type="checkbox"
                            value="1"
                            id="flexSwitchCheckDefault"
                            @if (old('published', $folder->published ?? '')) checked @endif
                            role="button">
                        <label class="form-check-label" for="flexSwitchCheckDefault" role="button">
                            <b>{{ __('validation.attributes.publishment') }}</b>
                        </label>
                        <br>
                        <small class="form-text text-body-secondary">
                            {{ __('validation.boolean', ['attribute' => __('validation.attributes.publishment')]) }}
                        </small>
                    </div>
                    @include('back.modules.input-error', ['inputName' => 'published'])
                </div>
            </div>
        </fieldset>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Submit button clone.
        const submit = document.getElementById('formSubmit')
            submitClone = document.getElementById('formSubmitClone');
        submitClone.addEventListener('click', (event) => {
            event.preventDefault();
            submit.click('');
        })
    });
</script>
@endpush
