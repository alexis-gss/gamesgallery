<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('form.authentification_name') }}</b>
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_name_user') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control need-word-counter"
                        placeholder="{{ __('form.name') }}"
                        value="{{ old('name', $user->name ?? '') }}">
                    <small class="text-muted">{{ __('form.name_label') }}</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('form.authentification_email') }}</b>
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_email') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'email'])'></div>
                    <input type="text"
                        id="email"
                        name="email"
                        class="form-control need-word-counter"
                        placeholder="{{ __('form.email') }}"
                        value="{{ old('email', $user->email ?? '') }}">
                    <small class="text-muted">{{ __('form.email_label') }}</small>
                    @include('back.modules.input-error', ['inputName' => 'email'])
                </div>
                @can('isAdmin')
                    <div class="col-12 col-md-6 form-group">
                        <label for="folder_id" class="col-form-label">
                            <b>{{ __('form.access') }}</b>
                            <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_role') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </svg>
                        </label>
                        <select class="form-select"
                            id="role"
                            name="role"
                            role="button">
                            <option value="{{ App\Enums\Role::admin()->value }}" @if ($user->role == App\Enums\Role::admin()->value) selected @endif>
                                {{ App\Enums\Role::admin()->label }}
                            </option>
                            <option value="{{ App\Enums\Role::visitor()->value }}" @if ($user->role == App\Enums\Role::visitor()->value) selected @endif>
                                {{ App\Enums\Role::visitor()->label }}
                            </option>
                        </select>
                        <small class="text-muted">{{ __('form.role_label') }}</small>
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
            <legend>{{ __('form.visuals') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="picture" class="col-form-label">
                        <b>{{ __('form.images') }}</b>
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_image') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </label>
                    <input type="file"
                        id="picture"
                        name="picture"
                        accept="image/jpg"
                        class="form-control mb-1">
                    <small class="text-muted">{{ __('form.images_label', [
                            'format' => Config::get('images.format'),
                            'width' => Config::get('images.maxwidth'),
                            'height' => Config::get('images.maxheight'),
                        ]) }}
                    </small>
                </div>
                @if($user->picture)
                    <div class="col-12 col-md-6 form-group">
                        <label class="col-form-label">
                            <b>{{ __('form.images_result') }}</b>
                        </label>
                        <div class="preview position-relative">
                            <img src="{{ asset($user->picture) }}" alt="{{ $user->picture_alt }}" style="max-height: 100px;">
                        <div class="filtre position-absolute h-100"></div>
                        @include('back.modules.input-error', ['inputName' => 'picture'])
                    </div>
                @endif
            </div>
        </fieldset>
    </div>
</div>

<div class="row @if (!Route::is('bo.users.create')) border-bottom @endif">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.security') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('form.password_new') }}</b>
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_password_user') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'password'])'></div>
                    <div class="input-group">
                        <input type="password"
                            id="password"
                            name="password"
                            class="form-control need-word-counter passwordInput"
                            placeholder="{{ __('form.password') }}"
                            value="{{ old('password') }}"
                            aria-describedby="btn-password">
                        <button class="btn btn-primary need-word-counter passwordBtn" type="button" id="btn-password">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                            <svg width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill d-none" viewBox="0 0 16 16">
                                <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                            </svg>
                        </button>
                    </div>
                    <small class="text-muted">{{ __('form.password_label') }}</small>
                    @include('back.modules.input-error', ['inputName' => 'password'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('form.password_confirm') }}</b>
                        <svg data-bs="tooltip" data-bs-placement="top" title="{{ __('form.tooltip_confirm_password_user') }}" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'password_confirmation'])'></div>
                    <div class="input-group">
                        <input type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control need-word-counter passwordInput"
                            placeholder="{{ __('form.confirm') }}"
                            value="{{ old('password_confirmation', $user->password_confirmation ?? '') }}"
                            aria-describedby="btn-password-confirm">
                        <button class="btn btn-primary need-word-counter passwordBtn" type="button" id="btn-password-confirm">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                            <svg width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill d-none" viewBox="0 0 16 16">
                                <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                            </svg>
                        </button>
                    </div>
                    <small class="text-muted">{{ __('form.confirmation_label') }}</small>
                    @include('back.modules.input-error', ['inputName' => 'passwordConfirm'])
                </div>
            </div>
        </fieldset>
    </div>
</div>
