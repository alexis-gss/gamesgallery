<div class="row">
    <div class="col-12 border-bottom">
        <fieldset class="p-3">
            <legend>{{ __('bo_title_general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label" for="folder_id">
                        <b>{{ __('bo_label_authentification', ['field' => __('validation.attributes.first_name')]) }}</b>
                        <span data-bs-tooltip="tooltip" data-bs-placement="top" title="{{ __('bo_tooltip_name_user') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'first_name'])'></div>
                    <input class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" type="text"
                        value="{{ old('first_name', $userModel->first_name ?? '') }}"
                        placeholder="{{ __('validation.attributes.first_name') }}">
                    <small class="text-body-secondary">
                        {{ __('validation.between.string', [
                            'attribute' => __('validation.attributes.first_name'),
                            'min' => 3,
                            'max' => 255,
                        ]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'first_name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label" for="folder_id">
                        <b>{{ __('bo_label_authentification', ['field' => __('validation.attributes.last_name')]) }}</b>
                        <span data-bs-tooltip="tooltip" data-bs-placement="top" title="{{ __('bo_tooltip_name_user') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'last_name'])'></div>
                    <input class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" type="text"
                        value="{{ old('last_name', $userModel->last_name ?? '') }}"
                        placeholder="{{ __('validation.attributes.last_name') }}">
                    <small class="text-body-secondary">
                        {{ __('validation.between.string', [
                            'attribute' => __('validation.attributes.last_name'),
                            'min' => 3,
                            'max' => 255,
                        ]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'last_name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label" for="folder_id">
                        <b>{{ __('bo_label_authentification', ['field' => __('validation.attributes.email')]) }}</b>
                        <span data-bs-tooltip="tooltip" data-bs-placement="top" title="{{ __('bo_tooltip_email') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'email'])'></div>
                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="text"
                        value="{{ old('email', $userModel->email ?? '') }}" placeholder="{{ __('validation.attributes.email') }}">
                    <small class="text-body-secondary">
                        {{ __('validation.email', ['attribute' => __('validation.attributes.email')]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'email'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label" for="folder_id">
                        <b>{{ __('bo_label_user_rights') }}</b>
                        <span data-bs-tooltip="tooltip" data-bs-placement="top" title="{{ __('bo_tooltip_role') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" role="button">
                        {{-- blade-formatter-disable --}}
                        @foreach (Arr::where(
                                \App\Enums\Users\RoleEnum::toArray(),
                                fn(object $role) => $role->value >= auth('backend')->user()->role->value()
                            ) as $associatedModel)
                            <option value="{{ $associatedModel->value }}" @if (old('role', $userModel->role->value ?? 1) === $associatedModel->value) selected @endif>
                                {{ $associatedModel->label }}
                            </option>
                        @endforeach
                        {{-- blade-formatter-enable --}}
                    </select>
                    <small class="text-body-secondary">
                        {{ __('validation.rule.select-single', ['entity' => __('validation.attributes.role')]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'role'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 border-bottom">
        <fieldset class="p-3">
            <legend>{{ Str::of(__('bo_title_visuals'))->singular() }}</legend>
            <div class="row mb-3">
                <div class="col-12 form-group">
                    @php
                        $data = [
                            'id' => 'userPicture',
                            'name' => 'picture',
                            'helper' => __('validation.rule.images_label', ['format' => 'JPG/PNG', 'width' => 100, 'height' => 100]),
                            'width' => 100,
                            'height' => 100,
                            'value' => $userModel->picture ?? '',
                        ];
                    @endphp
                    <div class="image-input" data-json='@json($data)'></div>
                    @include('back.modules.input-error', ['inputName' => 'picture'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('bo_title_security') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label" for="folder_id">
                        <b>{{ __('bo_label_password') }}</b>
                        <span data-bs-tooltip="tooltip" data-bs-placement="top" title="{{ __('bo_tooltip_password_user') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'password'])'></div>
                    <div class="input-group">
                        <input class="form-control password-input @error('password') is-invalid @enderror" id="password" name="password"
                            type="password" value="{{ old('password') }}" aria-describedby="btn-password"
                            placeholder="{{ __('validation.attributes.password') }}" autocomplete="new-password">
                        <button class="btn btn-primary password-btn" id="btn-password" data-bs-tooltip="tooltip" type="button"
                            title="{{ __('bo_tooltip_password_show_hide') }}">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-eye-slash d-none"></i>
                        </button>
                    </div>
                    <small class="text-body-secondary">
                        {{ __('validation.min.string', [
                            'attribute' => __('validation.attributes.password'),
                            'min' => 8,
                        ]) }}&nbsp;{{ __('validation.rule.password_empty') }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'password'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label" for="folder_id">
                        <b>{{ __('bo_label_password_confirm') }}</b>
                        <span data-bs-tooltip="tooltip" data-bs-placement="top" title="{{ __('bo_tooltip_confirm_password_user') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'password_confirmation'])'></div>
                    <div class="input-group">
                        <input class="form-control password-input @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" type="password"
                            value="{{ old('password_confirmation', $userModel->password_confirmation ?? '') }}"
                            aria-describedby="btn-password-confirm" placeholder="{{ __('validation.attributes.password_confirmation') }}"
                            autocomplete="new-password">
                        <button class="btn btn-primary password-btn" id="btn-password-confirm" data-bs-tooltip="tooltip" type="button"
                            title="{{ __('bo_tooltip_password_show_hide') }}">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-eye-slash d-none"></i>
                        </button>
                    </div>
                    <small class="text-body-secondary">
                        {{ __('validation.min.string', [
                            'attribute' => __('validation.attributes.password_confirmation'),
                            'min' => 8,
                        ]) }}&nbsp;{{ __('validation.rule.confirmation_label') }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'passwordConfirm'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 text-center">
        <p class="fw-bold m-0 p-0">{{ __('crud.other.required_fields') }}</p>
    </div>
</div>
