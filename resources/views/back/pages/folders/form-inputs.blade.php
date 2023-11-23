<div class="row">
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('bo_title_general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="name" class="col-form-label">
                        <b>{{ __('bo_label_identification') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('bo_tooltip_name_folder') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('validation.attributes.name') }}*"
                        value="{{ old('name', $folderModel->name ?? '') }}">
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
                        <b>{{ Str::of(__('validation.custom.color'))->ucFirst() }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('bo_tooltip_color_picker') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <input
                        id="color"
                        name="color"
                        type="text"
                        data-jscolor="{
                            value: '{{ old('color', $folderModel->color) }}',
                            borderColor: 'var(--bs-border-color)',
                            backgroundColor: 'rgb(var(--bs-body-bg-rgb))',
                            shadow: false,
                            palette:[
                                '#FFFFFF', '#808080', '#000000', '#996e36', '#f55525', '#ffe438', '#88dd20', '#22e0cd', '#269aff', '#bb1cd4'
                            ],
                        }"
                        class="form-control"
                        required>
                    <small class="text-body-secondary">
                        {{ __('validation.rule.color_label') }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'color'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('bo_title_visibility') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-check form-switch">
                    <div class="form-check form-switch">
                        <input class="form-check-input @error('published') is-invalid @enderror"
                            name="published"
                            type="checkbox"
                            value="1"
                            id="flexSwitchCheckDefault"
                            @if (old('published', $folderModel->published ?? '')) checked @endif
                            role="button">
                        <label class="form-check-label" for="flexSwitchCheckDefault" role="button">
                            <b>{{ Str::of(__('validation.custom.publishment'))->ucFirst() }}</b>
                        </label>
                        <br>
                        <small class="form-text text-body-secondary">
                            {{ __('validation.boolean', ['attribute' => __('validation.custom.publishment')]) }}
                        </small>
                    </div>
                    @include('back.modules.input-error', ['inputName' => 'published'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 text-center">
        <p class="fw-bold p-0 m-0">{{ __('crud.other.required_fields') }}</p>
    </div>
</div>

@can('update', $folderModel)
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
@endcan
