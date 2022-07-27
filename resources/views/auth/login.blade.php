@extends('layouts.backend')
@section('title', __('meta.back_office_login'))
@section('description', __('meta.back_office_login_desc'))
@section('metaIndex', 'noindex,nofollow')

@section('content')
    <div class="container mt-50">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('auth.title') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('bo.login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.login_mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" placeholder="{{ __('auth.placeholder_email') }}"
                                        title="{{ __('auth.placeholder_email') }}"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" autocomplete="email" required autofocus>

                                    @include('bo.modules.input-error', ['inputName' => 'email'])
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.login_password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        placeholder="{{ __('auth.placeholder_password') }}"
                                        title="{{ __('auth.placeholder_password') }}"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="current-password" required>

                                    @include('bo.modules.input-error', ['inputName' => 'password'])
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" title="{{ __('auth.login_btn') }}">
                                    {{ __('auth.login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
