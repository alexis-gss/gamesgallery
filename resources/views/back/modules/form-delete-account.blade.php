<div class="row">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.account') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label">
                        <b>{{ __('form.account_delete') }}</b>
                    </label>
                    <form action="{{ route('bo.users.destroy', $user->id) }}"
                        class="confirmDeleteTS"
                        method="POST"
                        novalidate>
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">
                            <span>{{ __('list.delete_user') }}</span>
                        </button>
                    </form>
                    <small class="text-muted">{{ __('form.action_irreversible') }}</small>
                </div>
            </div>
        </fieldset>
    </div>
</div>
