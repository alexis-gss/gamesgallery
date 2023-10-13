@extends('back.layout')

@section('title', __('texts.bo.other.back_office_login'))
@section('description', __('texts.bo.other.back_office_login_desc'))

@section('content')
<h1 class="title-font-regular text-center position-relative w-fit mx-auto mb-3 p-0 px-sm-5 py-1">
    {{ config('app.name') }}
    <span class="d-none d-sm-block angles"></span>
</h1>
<div class="card-auth row w-100 justify-content-center pb-5">
    <div class="col-12 p-0">
        <!-- Show a message when an action is performed -->
        @include('back.modules.flash-messages')
    </div>
    <div class="col-12 p-0">
        <form method="POST" action="{{ route('bo.login') }}" class="card p-3 p-sm-4">
            @csrf
            <div class="row mb-3">
                <h2 class="h2 text-center m-0 fw-bold">{{ __('auth.login') }}</h2>
            </div>
            <div class="row mb-3">
                <div class="col-sm-8 mx-auto">
                    <label for="email" class="col-form-label">
                        <b>{{ __('auth.login_mail') }}</b>
                    </label>
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
                <div class="col-sm-8 mx-auto">
                    <label for="password" class="col-form-label">
                        <b>{{ __('auth.login_password') }}</b>
                    </label>
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
