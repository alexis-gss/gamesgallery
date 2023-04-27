@extends('layouts.backend', ['brParam' => $tag])

@section('title', __('meta.tags_edition'))
@section('description', __('meta.tags_edition_desc'))
@section('keywords', 'noindex,nofollow')
@section('breadcrumb', request()->route()->getName())

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    <div class="d-flex flex-row align-items-start">
        <a href="{{ route('bo.tags.index') }}"
            class="btn btn-primary text-decoration-none m-0"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('form.return_list') }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        @include('breadcrumbs.breadcrumb-body', ['brParam' => $tag])
    </div>
    <div class="mb-2 mb-md-0">
        <form action="{{ route('bo.tags.destroy', $tag->id) }}"
            method="POST"
            class="confirmDeleteTS">
            @csrf
            @method('DELETE')
            <div class="btn-group" role="group">
                <button type="submit"
                    class="btn btn-danger"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('list.delete_tag') }}">
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
<form action="{{ route('bo.tags.update', $tag->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
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
