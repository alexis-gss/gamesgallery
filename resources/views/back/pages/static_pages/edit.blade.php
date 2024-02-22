@extends('back.layout', ['brParam' => $staticPageModel])

@section('title', __('crud.meta.edition_model', ['model' => trans_choice('models.static_page', 1)]))
@section('description', __('crud.meta.edition_model_desc', ['model' => trans_choice('models.static_page', 1)]))
@section('breadcrumb', request()->route()->getName())

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        <div class="d-flex align-items-start flex-row">
            <a class="btn btn-primary text-decoration-none m-0" data-bs-tooltip="tooltip" data-bs-placement="top"
                href="{{ route('bo.static_pages.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
                title="{{ __('crud.actions_model.list_all', ['model' => trans_choice('models.static_page', 2)]) }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            @include('breadcrumbs.breadcrumb-body', ['brParam' => $staticPageModel])
        </div>
        <div class="mb-md-0 mb-2">
            @canAny('update', $staticPageModel)
                <div class="btn-group" role="group">
                    <button class="btn btn-primary" id="formSubmitClone" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                        title="{{ __('crud.actions_model.save', ['model' => trans_choice('models.static_page', 1)]) }}">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
            @endcan
        </div>
    </div>
    @can('update', $staticPageModel)
        <form action="{{ route('bo.static_pages.update', $staticPageModel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        @endcan
        @include('back.pages.static_pages.form-inputs')
        @can('update', $staticPageModel)
            @include('back.partials.script-button-clone')
            <div class="row mt-3">
                <div class="col text-center">
                    <button class="btn btn-primary" id="formSubmit" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                        title="{{ __('crud.actions_model.save', ['model' => trans_choice('models.static_page', 1)]) }}">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
            </div>
        </form>
    @endcan
@endsection
