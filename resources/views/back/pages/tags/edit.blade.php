@extends('back.layout', ['brParam' => $tagModel])

@section('title', __('crud.meta.edition_model', ['model' => __('models.tag')]))
@section('description', __('crud.meta.edition_model_desc', ['model' => __('models.tag')]))
@section('breadcrumb', request()->route()->getName())

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    <div class="d-flex flex-row align-items-start">
        <a href="{{ route('bo.tags.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
            class="btn btn-primary text-decoration-none m-0"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('crud.actions_model.list_all', ['model' => Str::of(__('models.tag'))->plural()]) }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        @include('breadcrumbs.breadcrumb-body', ['brParam' => $tagModel])
    </div>
    <div class="mb-2 mb-md-0">
        @canAny(['delete', 'duplicate', 'update'], $tagModel)
        <form action="{{ route('bo.tags.destroy', $tagModel) }}"
            method="POST"
            class="confirmDeleteTS">
            @csrf
            @method('DELETE')
            <div class="btn-group" role="group">
                @can('duplicate', $tagModel)
                <a class="btn btn-secondary"
                    href="{{ route('bo.tags.duplicate', ['tag' => $tagModel]) }}"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.duplicate', ['model' => __('models.tag')]) }}">
                    <i class="fa-solid fa-copy"></i>
                </a>
                @endcan
                @can('update', $tagModel)
                <button id="formSubmitClone"
                    type="submit"
                    class="btn btn-primary"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.save', ['model' => __('models.tag')]) }}">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
                @endcan
                @can('delete', $tagModel)
                <button type="submit"
                    class="btn btn-danger"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.delete', ['model' => __('models.tag')]) }}">
                    <i class="fa-solid fa-trash"></i>
                </button>
                @endcan
            </div>
        </form>
        @endcan
    </div>
</div>
@can('update', $tagModel)
<form action="{{ route('bo.tags.update', $tagModel) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    @endcan
    @include('back.pages.tags.form-inputs')
    @can('update', $tagModel)
    <div class="row mt-3">
        <div class="col text-center">
            <button id="formSubmit"
                type="submit"
                class="btn btn-primary"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('crud.actions_model.save', ['model' => __('models.tag')]) }}">
                <i class="fa-solid fa-floppy-disk"></i>
            </button>
        </div>
    </div>
</form>
@endcan
@endsection
