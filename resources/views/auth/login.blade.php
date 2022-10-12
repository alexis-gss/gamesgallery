@extends('layouts.backend')
@section('title', __('meta.back_office_login'))
@section('description', __('meta.back_office_login_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
        <h1 class="h2 m-0 fw-bold">{{ __('other.back_office') }}
            <small class="text-muted h4">{{ __('auth.login') }}</small>
        </h1>
    </div>
    <div class="row justify-content-md-center mt-3">
        <div class="col col-xl-8 col-xxl-6">
            <form method="POST" action="{{ route('bo.login') }}">
                @csrf
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('auth.login_mail') }}</label>
                    <div class="col-md-6">
                        <input id="email" type="email" placeholder="{{ __('auth.placeholder_email') }}"
                            data-bs="tooltip" data-bs-placement="top"
                            title="{{ __('auth.placeholder_email') }}"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" autocomplete="email" required autofocus>
                        @include('back.modules.input-error', ['inputName' => 'email'])
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password"
                        class="col-md-4 col-form-label text-md-end">{{ __('auth.login_password') }}</label>
                    <div class="col-md-6">
                        <input id="password" type="password" placeholder="{{ __('auth.placeholder_password') }}"
                            data-bs="tooltip" data-bs-placement="top"
                            title="{{ __('auth.placeholder_password') }}"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            autocomplete="current-password" required>

                        @include('back.modules.input-error', ['inputName' => 'password'])
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" data-bs="tooltip" data-bs-placement="top"
                        title="{{ __('auth.login_btn') }}">
                        {{ __('auth.login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
