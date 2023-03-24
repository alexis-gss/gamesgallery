<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
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
                        class="form-control need-word-counter @error('name') is-invalid @enderror"
                        placeholder="{{ __('form.name') }}*"
                        value="{{ old('name', $folder->name ?? '') }}">
                    <small class="text-muted">{{ __('form.name_label') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.visibility') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-check form-switch">
                    <div class="form-check form-switch">
                        <input class="form-check-input @error('status') is-invalid @enderror"
                            name="status"
                            type="checkbox"
                            value="1"
                            id="flexSwitchCheckDefault"
                            @if (old('status', $folder->status ?? '')) checked @endif
                            role="button">
                        <label class="form-check-label" for="flexSwitchCheckDefault" role="button">
                            <b>{{ __('form.publish') }}</b>
                        </label>
                        <br>
                        <small class="form-text text-muted">{{ __('form.publish_label') }}</small>
                    </div>
                    @include('back.modules.input-error', ['inputName' => 'status'])
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
