@extends('layouts.backend')
@section('title', __('texts.bo.other.back_office_login'))
@section('description', __('texts.bo.other.back_office_login_desc'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
    <h1 class="h2 m-0 fw-bold">{{ __('texts.bo.other.back_office') }}
        <small class="text-body-secondary h4">{{ __('auth.login') }}</small>
    </h1>
</div>
<div class="row justify-content-md-center mt-3">
    <div class="col col-xl-8 col-xxl-4">
        <form method="POST" action="{{ route('bo.login') }}">
            @csrf
            <div class="row mb-3">
                <label for="email" class="col-form-label">
                    <b>{{ __('auth.login_mail') }}</b>
                </label>
                <div>
                    <input id="email"
                        type="email"
                        placeholder="{{ __('auth.placeholder_email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus>
                    @include('back.modules.input-error', ['inputName' => 'email'])
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-form-label">
                    <b>{{ __('auth.login_password') }}</b>
                </label>
                <div>
                    <input id="password"
                        type="password"
                        placeholder="{{ __('auth.placeholder_password') }}"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        autocomplete="current-password">
                    @include('back.modules.input-error', ['inputName' => 'password'])
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit"
                    class="btn btn-primary"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('auth.login_btn') }}">
                    {{ __('auth.login') }}
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
