@extends('bo.layout', ['brParam' => $staticPageModel])

@section('title', __('Édition d\'un :model', ['model' => __('models.classes.static_page')]))
@section('description', __('Édition d\'un :model déjà existant', ['model' => __('models.classes.static_page')]))
@section('breadcrumb',
    request()->route()->getName())

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center flex-wrap pb-3">
        <div class="d-flex align-items-start flex-row">
            <a class="btn btn-primary text-decoration-none m-0" data-bs-toggle="tooltip" href="{{ route('bo.static_pages.index') }}"
                title="{{ __('crud.helpers.list_all', ['model' => Str::plural(__('models.classes.static_page'))]) }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            @include('modules.breadcrumbs.breadcrumb-body', ['brParam' => $staticPageModel])
        </div>
        <div class="mb-md-0 mb-2">
            <div class="btn-group">
                <button class="btn btn-primary" id="formSubmitClone" data-bs-toggle="tooltip" type="submit"
                    title="{{ __('crud.helpers.save_model', ['model' => __('models.classes.static_page')]) }}">
                    {{ Str::ucfirst(__('crud.actions.save')) }}
                </button>
            </div>
        </div>
    </div>
    <form action="{{ route('bo.static_pages.update', $staticPageModel) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('bo.pages.static_pages.form')
        <div class="row">
            <div class="col text-center">
                <button class="btn btn-primary" id="formSubmit" data-bs-toggle="tooltip" type="submit"
                    title="{{ __('crud.helpers.save_model', ['model' => __('models.classes.static_page')]) }}">
                    {{ Str::ucfirst(__('crud.actions.save')) }}
                </button>
            </div>
        </div>
    </form>
@endsection
