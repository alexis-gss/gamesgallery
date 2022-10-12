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
                        <svg width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
