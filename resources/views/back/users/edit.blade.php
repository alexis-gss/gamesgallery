@extends('layouts.backend', ['brParam' => $user])

@section('title', __('meta.users_edition'))
@section('description', __('meta.users_edition_desc'))
@section('keywords', 'noindex,nofollow')
@section('breadcrumb', request()->route()->getName())

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 border-top border-bottom">
    <h1 class="d-flex flex-row align-items-start h2 m-0 fw-bold">
        <a href="{{ route('bo.users.index') }}"
            class="btn btn-primary text-decoration-none m-0"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('form.return_list') }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="ms-2">
            {{ __('form.user') }}
            <small class="text-muted h4">{{ __('form.edition') }}</small>
        </span>
    </h1>
    <div class="mb-2 mb-md-0">
        <form action="{{ route('bo.users.destroy', $user->id) }}"
            method="POST"
            class="confirmDeleteTS">
            @csrf
            @method('DELETE')
            <div class="btn-group" role="group">
                <button type="submit"
                    class="btn btn-danger"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('list.delete_user') }}">
                    <i class="fa-solid fa-trash"></i>
                </button>
                <button id="formSubmitClone"
                    type="submit"
                    class="btn btn-primary"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('form.save') }}">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<form action="{{ route('bo.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('back.users.form-inputs')
    <div class="row mt-3">
        <div class="col text-center">
            <button id="formSubmit"
                type="submit"
                class="btn btn-primary"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('form.save') }}">
                <i class="fa-solid fa-floppy-disk"></i>
            </button>
        </div>
    </div>
</form>
@endsection
