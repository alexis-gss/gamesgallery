@extends('layouts.backend')

@section('title', __('crud.meta.all_models', ['model' => __('models.folders')]))
@section('description', __('crud.meta.all_models_list', ['model' => __('models.folders')]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('isAdmin')
    <a href="{{ route('bo.folders.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('crud.actions_model.create', ['model' => Str::singular(__('models.folders'))]) }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<table class="table table-hover">
    @if (count($folders) > 0)
    <thead>
        @include('back.modules.table-col-sorter', [
            'cols' => [
                'name'      => __('validation.attributes.name'),
                'color'     => __('validation.attributes.color'),
                'published' => __('validation.attributes.publishment'),
                'order'     => __('validation.attributes.order')
            ],
        ])
    </thead>
    <tbody>
        @foreach ($folders as $folder)
        <tr class="border-bottom">
            <td class="text-center align-middle">{{ $folder->name }}</td>
            <td class="text-center align-middle">
                <div class="btn-sm mx-auto"
                    title="{{ __('texts.bo.tooltip.color_details', ['color' => $folder->color]) }}"
                    data-bs="tooltip">
                    <span class="d-block w-100 h-100 rounded-1" style="background-color:{{ $folder->color }}"></span>
                </div>
            </td>
            @include('back.modules.change-published-status', [
                'routeName' => 'folders',
                'model'     => $folder
            ])
            @php $routeName = request()->route()->getName(); @endphp
            @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
            @include('back.modules.change-model-order', [
                'routeName' => 'folders',
                'models'    => $folders,
                'model'     => $folder
            ])
            @endif
            <td class="text-end align-middle">
                @can('isAdmin')
                <form action="{{ route('bo.folders.destroy', $folder->id) }}"
                    method="POST"
                    class="btn-group confirmDeleteTS"
                    novalidate>
                    <a class="btn btn-sm btn-secondary"
                        href="{{ route('bo.folders.duplicate', ['folder' => $folder->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('crud.actions_model.duplicate', ['model' => Str::singular(__('models.folders'))]) }}">
                        <i class="fa-solid fa-copy"></i>
                    </a>
                    <a class="btn btn-sm btn-primary"
                        href="{{ route('bo.folders.edit', ['folder' => $folder->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('crud.actions_model.edit', ['model' => Str::singular(__('models.folders'))]) }}">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn btn-sm btn-danger"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('crud.actions_model.delete', ['model' => Str::singular(__('models.folders'))]) }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
                @else
                @include('back.modules.user-right')
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
    @else
    <tr>
        <td class="border-0">{{ __('crud.other.no_model_found', ['model' => Str::singular(__('models.folders'))]) }}</td>
    </tr>
    @endif
</table>
{!! $folders->links() !!}
@endsection
