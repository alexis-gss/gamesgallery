<div class="row border-bottom">
    <div class="col">
        <fieldset class="p-3">
            <legend>{{ __('form.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.identification') }}</b></label>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="{{ __('form.type_name_user') }}*"
                        value="{{ old('name', $user->name ?? '') }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.type_name_user') }}">
                    <small class="text-muted">{{ __('form.name') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.authentification') }}</b></label>
                    <input type="text"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="{{ __('form.type_email') }}*"
                        value="{{ old('email', $user->email ?? '') }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.type_email') }}">
                    <small class="text-muted">{{ __('form.email') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'email'])
                </div>
                @can('isAdmin')
                    <div class="col-12 col-md-6 form-group">
                        <label for="folder_id" class="col-form-label"><b>{{ __('form.access') }}</b></label>
                        <select class="form-select"
                            id="role"
                            name="role"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('form.select_role') }}"
                            role="button">
                            <option value="{{ App\Enums\Role::admin()->value }}" @if ($user->role == App\Enums\Role::admin()->value) selected @endif>
                                {{ App\Enums\Role::admin()->label }}
                            </option>
                            <option value="{{ App\Enums\Role::visitor()->value }}" @if ($user->role == App\Enums\Role::visitor()->value) selected @endif>
                                {{ App\Enums\Role::visitor()->label }}
                            </option>
                        </select>
                        <small class="text-muted">{{ __('form.role') }}*</small>
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
                    <label for="picture" class="col-form-label"><b>{{ __('form.images') }}</b></label>
                    <input type="file"
                        id="picture"
                        name="picture"
                        accept="image/jpg"
                        class="form-control mb-1"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.select_images') }}">
                    <small
                        class="text-muted">{{ __('form.images_rules', [
                            'format' => Config::get('images.format'),
                            'width' => Config::get('images.maxwidth'),
                            'height' => Config::get('images.maxheight'),
                        ]) }}
                    </small>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label"><b>{{ __('form.preview') }}</b></label>
                    <div class="preview position-relative">
                        <img src="{{ asset($user->picture) }}" alt="{{ $user->picture_alt }}" style="max-height: 100px;">
                    <div class="filtre position-absolute h-100"></div>
                    @include('back.modules.input-error', ['inputName' => 'picture'])
                </div>
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
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.password_new') }}</b></label>
                    <input type="text"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="{{ __('form.type_password_user') }}*"
                        value="{{ old('password') }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.type_password_user') }}">
                    <small class="text-muted">{{ __('form.password') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'password'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label"><b>{{ __('form.confirmation') }}</b></label>
                    <input type="text"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="{{ __('form.type_confirm_password_user') }}*"
                        value="{{ old('password_confirmation', $user->password_confirmation ?? '') }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('form.type_confirm_password_user') }}">
                    <small class="text-muted">{{ __('form.password_confirm') }}*</small>
                    @include('back.modules.input-error', ['inputName' => 'passwordConfirm'])
                </div>
            </div>
        </fieldset>
    </div>
</div>