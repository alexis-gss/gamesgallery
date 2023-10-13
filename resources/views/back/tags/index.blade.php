@extends('layouts.backend')

@section('title', __('meta.all_tags'))
@section('description', __('meta.all_tags_desc'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('isAdmin')
    <a href="{{ route('bo.tags.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('list.create_new_tag') }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<table class="table table-hover">
    @if (count($tags) > 0)
    <thead>
        @php
        $cols = [
            'name' => __('list.name'),
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
        @foreach ($tags as $tag)
        <tr class="border-bottom">
            <td class="text-center align-middle">{{ $tag->name }}</td>
            @include('back.modules.change-published-status', [
                'routeName' => 'tags',
                'model' => $tag
            ])
            @php $routeName = request()->route()->getName(); @endphp
            @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
            @include('back.modules.change-model-order', [
                'routeName' => 'tags',
                'models' => $tags,
                'model' => $tag
            ])
            @endif
            <td class="text-end align-middle">
                @can('isAdmin')
                <form action="{{ route('bo.tags.destroy', $tag->id) }}"
                    method="POST"
                    class="btn-group confirmDeleteTS"
                    novalidate>
                    <a class="btn btn-sm btn-secondary"
                        href="{{ route('bo.tags.duplicate', ['tag' => $tag->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.duplicate_tag') }}">
                        <i class="fa-solid fa-copy"></i>
                    </a>
                    <a class="btn btn-sm btn-primary"
                        href="{{ route('bo.tags.edit', ['tag' => $tag->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.edit_tag') }}">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn btn-sm btn-danger"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.delete_tag') }}">
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
        <td class="border-0">{{ __('list.no_tags_found') }}</td>
    </tr>
    @endif
</table>
{!! $tags->links() !!}
@endsection
