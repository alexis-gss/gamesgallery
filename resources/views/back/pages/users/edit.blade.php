@extends('back.layout', ['brParam' => $userModel])

@section('title', __('crud.meta.edition_model', ['model' => __('models.user')]))
@section('description', __('crud.meta.edition_model_desc', ['model' => __('models.user')]))
@section('breadcrumb',
    request()->route()->getName())

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        <div class="d-flex align-items-start flex-row">
            <a class="btn btn-primary text-decoration-none m-0" data-bs-tooltip="tooltip" data-bs-placement="top"
                href="{{ route('bo.users.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
                title="{{ __('crud.actions_model.list_all', ['model' => Str::of(__('models.user'))->plural()]) }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            @include('breadcrumbs.breadcrumb-body', ['brParam' => $userModel])
        </div>
        <div class="mb-md-0 mb-2">
            @canAny(['delete', 'duplicate', 'update'], $userModel)
                <form class="confirmDeleteTS" action="{{ route('bo.users.destroy', $userModel) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="btn-group" role="group">
                        @can('duplicate', $userModel)
                            <a class="btn btn-secondary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                href="{{ route('bo.users.duplicate', ['user' => $userModel]) }}"
                                title="{{ __('crud.actions_model.duplicate', ['model' => __('models.user')]) }}">
                                <i class="fa-solid fa-copy"></i>
                            </a>
                        @endcan
                        @can('update', $userModel)
                            <button class="btn btn-primary" id="formSubmitClone" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                                title="{{ __('crud.actions_model.save', ['model' => __('models.user')]) }}">
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                        @endcan
                        @can('delete', $userModel)
                            <button class="btn btn-danger" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                                title="{{ __('crud.actions_model.delete', ['model' => __('models.user')]) }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        @endcan
                    </div>
                </form>
            @endcan
        </div>
    </div>
    @can('update', $userModel)
        <form action="{{ route('bo.users.update', $userModel) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
        @endcan
        @include('back.pages.users.form-inputs')
        @can('update', $userModel)
            <div class="row mt-3">
                <div class="col text-center">
                    <button class="btn btn-primary" id="formSubmit" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                        title="{{ __('crud.actions_model.save', ['model' => __('models.user')]) }}">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
            </div>
        </form>
    @endcan
@endsection
