@extends('layouts.backend')

@section('title', __('meta.tags_creation'))
@section('description', __('meta.tags_creation_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 border-top border-bottom">
    <h1 class="d-flex flex-row align-items-start h2 m-0 fw-bold">
        <a href="{{ route('bo.tags.index') }}"
            class="btn btn-primary text-decoration-none m-0"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('form.return_list') }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="ms-2">
            {{ __('form.tag') }}
            <small class="text-muted h4">{{ __('form.creation') }}</small>
        </span>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button id="formSubmitClone"
            type="submit"
            class="btn btn-primary"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('form.save') }}">
            <i class="fa-solid fa-floppy-disk"></i>
        </button>
    </div>
</div>
<form action="{{ route('bo.tags.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('back.tags.form-inputs')
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
