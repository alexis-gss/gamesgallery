@extends('layouts.backend')

@section('title', __('crud.meta.all_models', ['model' => __('models.tags')]))
@section('description', __('crud.meta.all_models_list', ['model' => __('models.tags')]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('isAdmin')
    <a href="{{ route('bo.tags.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('crud.actions_model.create', ['model' => Str::singular(__('models.tags'))]) }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<div class="table-responsive mb-3">
    <table class="table table-hover table-fix-action m-0">
        @if (count($tags) > 0)
        <thead>
            @include('back.modules.table-col-sorter', [
                'cols' => [
                    'name'       => __('validation.attributes.name'),
                    'published'  => __('validation.attributes.publishment'),
                    'updated_at' => __('validation.attributes.updated_at'),
                    'order'      => __('validation.attributes.order')
                ],
            ])
        </thead>
        <tbody>
            @foreach ($tags as $tag)
            <tr class="border-bottom">
                <td class="text-center align-middle">{{ $tag->name }}</td>
                @include('back.modules.change-published-status', [
                    'routeName' => 'tags',
                    'model'     => $tag
                ])
                <td class="text-center align-middle">
                    <span class="badge bg-secondary">{{ $tag->updated_at }}</span>
                </td>
                @php $routeName = request()->route()->getName(); @endphp
                @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
                @include('back.modules.change-model-order', [
                    'routeName' => 'tags',
                    'models'    => $tags,
                    'model'     => $tag
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
                            title="{{ __('crud.actions_model.duplicate', ['model' => Str::singular(__('models.tags'))]) }}">
                            <i class="fa-solid fa-copy"></i>
                        </a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('bo.tags.edit', ['tag' => $tag->id]) }}"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.edit', ['model' => Str::singular(__('models.tags'))]) }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-sm btn-danger"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.delete', ['model' => Str::singular(__('models.tags'))]) }}">
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
            <td class="border-0">{{ __('crud.other.no_model_found', ['model' => Str::singular(__('models.tags'))]) }}</td>
        </tr>
        @endif
    </table>
</div>
{!! $tags->links() !!}
@endsection
