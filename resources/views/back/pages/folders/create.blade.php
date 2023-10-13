@extends('back.layout', ['brParam' => $folderModel])

@section('title', __('crud.meta.creation_model', ['model' => __('models.folder')]))
@section('description', __('crud.meta.creation_model_desc', ['model' => __('models.folder')]))
@section('breadcrumb', request()->route()->getName())

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    <div class="d-flex flex-row align-items-start">
        <a href="{{ route('bo.folders.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
            class="btn btn-primary text-decoration-none m-0"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('crud.actions_model.list_all', ['model' => Str::of(__('models.folder'))->plural()]) }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        @include('breadcrumbs.breadcrumb-body', ['brParam' => $folderModel])
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        @can('create', $folderModel)
        <button id="formSubmitClone"
            type="submit"
            class="btn btn-primary"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('crud.actions_model.save', ['model' => __('models.folder')]) }}">
            <i class="fa-solid fa-floppy-disk"></i>
        </button>
        @endcan
    </div>
</div>
@can('create', $folderModel)
<form action="{{ route('bo.folders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @endcan
    @include('back.pages.folders.form-inputs')
    @can('create', $folderModel)
    <div class="row mt-3">
        <div class="col text-center">
            <button id="formSubmit"
                type="submit"
                class="btn btn-primary"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('crud.actions_model.save', ['model' => __('models.folder')]) }}">
                <i class="fa-solid fa-floppy-disk"></i>
            </button>
        </div>
    </div>
    @endcan
</form>
@endsection
