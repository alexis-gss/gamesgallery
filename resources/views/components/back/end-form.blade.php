@can($action, $model)
    <div class="col-12 text-center">
        <p><b>{{ str(__('crud.other.required_fields'))->ucFirst() }}</b></p>
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-primary" id="formSubmit" data-bs-tooltip="tooltip" type="submit"
            title="{{ __('crud.actions_model.save', ['model' => $modelTranslation]) }}">
            {{ str(__('crud.actions.save'))->ucFirst() }}
        </button>
        @push('scripts')
            <script nonce="{{ $nonce }}">
                document.addEventListener("DOMContentLoaded", () => {
                    const submit = document.getElementById('formSubmit')
                        submitClone = document.getElementById('formSubmitClone');
                    submitClone.addEventListener('click', (event) => {
                        event.preventDefault();
                        submit.click('');
                    })
                });
            </script>
        @endpush
    </div>
@endcan
