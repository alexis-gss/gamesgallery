@extends('layouts.backend')

@section('title', __('meta.all_folders'))
@section('description', __('meta.all_folders_desc'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('isAdmin')
    <a href="{{ route('bo.folders.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('list.create_new_folder') }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<table class="table table-hover">
    @if (count($folders) > 0)
    <thead>
        @php
        $cols = [
            'name' => __('list.name'),
            'color' => __('list.color'),
            'published' => __('list.publishment'),
            'order' => __('list.order')
        ];
        @endphp
        @include('back.modules.table-col-sorter', [
            'cols' => $cols,
            'mobileHide' => [],
        ])
    </thead>
    <tbody>
        @foreach ($folders as $folder)
        <tr class="border-bottom">
            <td class="text-center align-middle">{{ $folder->name }}</td>
            <td class="text-center align-middle">
                <div class="btn-sm mx-auto"
                    title="{{ __('list.color_details', ['color' => $folder->color]) }}"
                    data-bs="tooltip">
                    <span class="d-block w-100 h-100 rounded-1" style="background-color:{{ $folder->color }}"></span>
                </div>
            </td>
            @include('back.modules.change-published-status', [
                'routeName' => 'folders',
                'model' => $folder
            ])
            @php $routeName = request()->route()->getName(); @endphp
            @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
            @include('back.modules.change-model-order', [
                'routeName' => 'folders',
                'models' => $folders,
                'model' => $folder
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
                        title="{{ __('list.duplicate_folder') }}">
                        <i class="fa-solid fa-copy"></i>
                    </a>
                    <a class="btn btn-sm btn-primary"
                        href="{{ route('bo.folders.edit', ['folder' => $folder->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.edit_folder') }}">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn btn-sm btn-danger"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.delete_folder') }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
                @else
                <span class="text-danger"
                    title="{{ __('list.right') }}"
                    data-bs="tooltip">
                    <i class="fa-solid fa-ban"></i>
                </span>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
    @else
    <tr>
        <td class="border-0">{{ __('list.no_folders_found') }}</td>
    </tr>
    @endif
</table>
{!! $folders->links() !!}
@endsection
