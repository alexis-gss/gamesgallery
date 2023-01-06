@extends('layouts.backend')

@section('title', __('meta.folders_edition'))
@section('description', __('meta.folders_edition_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <form action="{{ route('bo.folders.update', $folder->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
            <h1 class="d-flex flex-row align-items-start h2 m-0 fw-bold">
                <a href="{{ route('bo.folders.index') }}"
                    class="btn btn-primary text-decoration-none m-0"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('form.return_list') }}">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <span class="ms-2">
                    {{ __('form.folder') }}
                    <small class="text-muted h4">{{ __('form.edition') }}</small>
                </span>
            </h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="submit"
                    class="btn btn-primary"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('form.save') }}">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
        @include('back.folders.form-inputs')
    </form>
@endsection
