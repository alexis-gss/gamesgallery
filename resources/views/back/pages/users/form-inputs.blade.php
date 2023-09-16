<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('texts.bo.title.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('texts.bo.label.authentification_name') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.name_user') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('validation.attributes.name') }}"
                        value="{{ old('name', $user->name ?? '') }}">
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
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('texts.bo.label.authentification_email') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.email') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'email'])'></div>
                    <input type="text"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="{{ __('validation.attributes.email') }}"
                        value="{{ old('email', $user->email ?? '') }}">
                    <small class="text-body-secondary">
                        {{ __('validation.email', ['attribute' => __('validation.attributes.email')]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'email'])
                </div>
                @can('isAdmin')
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('texts.bo.label.user_rights') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.role') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <select class="form-select @error('role') is-invalid @enderror"
                        id="role"
                        name="role"
                        role="button">
                        <option value="{{ \App\Enums\Users\RoleEnum::admin->value }}"
                            @if(isset($user->role) && $user->role === \App\Enums\Users\RoleEnum::admin) selected @endif>
                            {{ \App\Enums\Users\RoleEnum::admin->label() }}
                        </option>
                        <option value="{{ \App\Enums\Users\RoleEnum::visitor->value }}"
                            @if(isset($user->role) && $user->role === \App\Enums\Users\RoleEnum::visitor) selected @endif>
                            {{ \App\Enums\Users\RoleEnum::visitor->label() }}
                        </option>
                    </select>
                    <small class="text-body-secondary">
                        {{ __('validation.custom.select-single', ['entity' => __('validation.attributes.role')]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'role'])
                </div>
                @endcan
            </div>
        </fieldset>
    </div>
</div>
<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ Str::singular(__('texts.bo.title.visuals')) }}</legend>
            <div class="row mb-3">
                <div class="col-12 form-group">
                    @php
                    $data = [
                        'id' => 'userPicture',
                        'name' => 'picture',
                        'helper' => __('validation.custom.images_label', ['format' => 'JPG/PNG', 'width' => 100, 'height' => 100]),
                        'width' => 100,
                        'height' => 100,
                        'value' => $user->picture ?? ''
                    ];
                    @endphp
                    <div class="image-input" data-json='@json($data)'></div>
                    @include('back.modules.input-error', ['inputName' => 'picture'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('texts.bo.title.security') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('texts.bo.label.password') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.password_user') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'password'])'></div>
                    <div class="input-group">
                        <input type="password"
                            id="password"
                            name="password"
                            class="form-control password-input @error('password') is-invalid @enderror"
                            placeholder="{{ __('validation.attributes.password') }}"
                            value="{{ old('password') }}"
                            aria-describedby="btn-password"
                            autocomplete="new-password">
                        <button class="btn btn-primary password-btn"
                            title="{{ __('texts.bo.tooltip.password_show_hide') }}"
                            data-bs="tooltip"
                            type="button"
                            id="btn-password">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-eye-slash d-none"></i>
                        </button>
                    </div>
                    <small class="text-body-secondary">
                        {{ __('validation.min.string', [
                            'attribute' => __('validation.attributes.password'),
                            'min' => 8,
                        ]) }}&nbsp;{{ __('validation.custom.password_empty') }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'password'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('texts.bo.label.password_confirm') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.confirm_password_user') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'password_confirmation'])'></div>
                    <div class="input-group">
                        <input type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control password-input @error('password_confirmation') is-invalid @enderror"
                            placeholder="{{ __('validation.attributes.password_confirm') }}"
                            value="{{ old('password_confirmation', $user->password_confirmation ?? '') }}"
                            aria-describedby="btn-password-confirm"
                            autocomplete="new-password">
                        <button class="btn btn-primary password-btn"
                            title="{{ __('texts.bo.tooltip.password_show_hide') }}"
                            data-bs="tooltip"
                            type="button"
                            id="btn-password-confirm">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-eye-slash d-none"></i>
                        </button>
                    </div>
                    <small class="text-body-secondary">
                        {{ __('validation.min.string', [
                            'attribute' => __('validation.attributes.password_confirm'),
                            'min' => 8,
                        ]) }}&nbsp;{{ __('validation.custom.confirmation_label') }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'passwordConfirm'])
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
