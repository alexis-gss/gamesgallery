<div class="row">
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3 mb-3">
            <legend>{{ __('texts.bo.title.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="name" class="col-form-label">
                        <b>{{ __('texts.bo.label.identification') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.name_tag') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('validation.attributes.name') }}*"
                        value="{{ old('name', $tagModel->name ?? '') }}">
                    <small class="text-body-secondary">
                        {{ __('validation.between.string', [
                            'attribute' => __('validation.attributes.name'),
                            'min' => 3,
                            'max' => 255
                        ]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 border-bottom mb-3">
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
                            @if (old('published', $tagModel->published ?? '')) checked @endif
                            role="button">
                        <label class="form-check-label" for="flexSwitchCheckDefault" role="button">
                            <b>{{ Str::of(__('validation.custom.publishment'))->ucfirst() }}</b>
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

@can('update', $tagModel)
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
