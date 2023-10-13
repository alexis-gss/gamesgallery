@extends('back.layout', ['brParam' => $folderModel])

@section('title', __('crud.meta.edition_model', ['model' => __('models.folder')]))
@section('description', __('crud.meta.edition_model_desc', ['model' => __('models.folder')]))
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
    <div class="mb-2 mb-md-0">
        @canAny(['delete', 'duplicate', 'update'], $folderModel)
        <form action="{{ route('bo.folders.destroy', $folderModel) }}"
            method="POST"
            class="confirmDeleteTS">
            @csrf
            @method('DELETE')
            <div class="btn-group" role="group">
                @can('duplicate', $folderModel)
                <a class="btn btn-secondary"
                    href="{{ route('bo.folders.duplicate', ['folder' => $folderModel]) }}"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.duplicate', ['model' => __('models.folder')]) }}">
                    <i class="fa-solid fa-copy"></i>
                </a>
                @endcan
                @can('update', $folderModel)
                <button id="formSubmitClone"
                    type="submit"
                    class="btn btn-primary"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.save', ['model' => __('models.folder')]) }}">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
                @endcan
                @can('delete', $folderModel)
                <button type="submit"
                    class="btn btn-danger"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.delete', ['model' => __('models.folder')]) }}">
                    <i class="fa-solid fa-trash"></i>
                </button>
                @endcan
            </div>
        </form>
        @endcan
    </div>
</div>
@can('update', $folderModel)
<form action="{{ route('bo.folders.update', $folderModel) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    @endcan
    @include('back.pages.folders.form-inputs')
    @can('update', $folderModel)
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
</form>
@endcan
@endsection
