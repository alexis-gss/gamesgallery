@extends('back.layout', ['brParam' => $gameModel])

@section('title', __('crud.meta.edition_model', ['model' => __('models.game')]))
@section('description', __('crud.meta.edition_model_desc', ['model' => __('models.game')]))
@section('breadcrumb', request()->route()->getName())

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    <div class="d-flex flex-row align-items-start">
        <a href="{{ route('bo.games.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
            class="btn btn-primary text-decoration-none m-0"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('crud.actions_model.list_all', ['model' => Str::of(__('models.game'))->plural()]) }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        @include('breadcrumbs.breadcrumb-body', ['brParam' => $gameModel])
    </div>
    <div class="mb-2 mb-md-0">
        @canAny(['delete', 'duplicate', 'update'], $gameModel)
        <form action="{{ route('bo.games.destroy', $gameModel) }}"
            method="POST"
            class="confirmDeleteTS">
            @csrf
            @method('DELETE')
            <div class="btn-group" role="group">
                @can('view', $gameModel)
                <a href="{{ route('fo.games.specific', $gameModel->slug) }}"
                    class="btn btn-warning"
                    target="_blank"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.show', ['model' => __('models.game')]) }}">
                    <i class="fa-solid fa-eye"></i>
                </a>
                @endcan
                @can('duplicate', $gameModel)
                <a class="btn btn-secondary"
                    href="{{ route('bo.games.duplicate', ['game' => $gameModel]) }}"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.duplicate', ['model' => __('models.game')]) }}">
                    <i class="fa-solid fa-copy"></i>
                </a>
                @endcan
                @can('update', $gameModel)
                <button id="formSubmitClone"
                    type="submit"
                    class="btn btn-primary"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.save', ['model' => __('models.game')]) }}">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
                @endcan
                @can('delete', $gameModel)
                <button type="submit"
                    class="btn btn-danger"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('crud.actions_model.delete', ['model' => __('models.game')]) }}">
                    <i class="fa-solid fa-trash"></i>
                </button>
                @endcan
            </div>
        </form>
        @endcan
    </div>
</div>
<form action="{{ route('bo.games.update', $gameModel) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('back.pages.games.form-inputs')
    <div class="row mt-3">
        <div class="col text-center">
            <button id="formSubmit"
                type="submit"
                class="btn btn-primary"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('crud.actions_model.save', ['model' => __('models.game')]) }}">
                <i class="fa-solid fa-floppy-disk"></i>
            </button>
        </div>
    </div>
</form>
@endsection
