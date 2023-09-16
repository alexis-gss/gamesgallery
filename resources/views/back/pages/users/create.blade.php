@extends('back.layout', ['brParam' => $user])

@section('title', __('crud.meta.creation_model', ['model' => Str::singular(__('models.tags'))]))
@section('description', __('crud.meta.creation_model_desc', ['model' => Str::singular(__('models.tags'))]))
@section('breadcrumb', request()->route()->getName())

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    <div class="d-flex flex-row align-items-start">
        <a href="{{ route('bo.users.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
            class="btn btn-primary text-decoration-none m-0"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('crud.actions_model.list_all', ['model' => __('models.users')]) }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        @include('breadcrumbs.breadcrumb-body', ['brParam' => $user])
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button id="formSubmitClone"
            type="submit"
            class="btn btn-primary"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('crud.actions_model.save', ['model' => Str::singular(__('models.users'))]) }}">
            <i class="fa-solid fa-floppy-disk"></i>
        </button>
    </div>
</div>
<form action="{{ route('bo.users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('back.pages.users.form-inputs')
    <div class="row mt-3">
        <div class="col text-center">
            <button id="formSubmit"
                type="submit"
                class="btn btn-primary"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('crud.actions_model.save', ['model' => Str::singular(__('models.users'))]) }}">
                <i class="fa-solid fa-floppy-disk"></i>
            </button>
        </div>
    </div>
</form>
@endsection
