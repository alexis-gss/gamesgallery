@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => Str::of(__('models.tag'))]))
@section('description', __('crud.meta.all_models_list', ['model' => Str::of(__('models.tag'))]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('create', \App\Models\Tag::class)
    <a href="{{ route('bo.tags.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('crud.actions_model.create', ['model' => __('models.tag')]) }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<div class="table-responsive mb-3">
    <table class="table table-hover table-fix-action m-0">
        @if (count($tagModels) > 0)
        <thead>
            @include('back.modules.table-col-sorter', [
                'cols' => [
                    'name'       => Str::of(__('validation.attributes.name'))->ucfirst(),
                    'published'  => Str::of(__('validation.custom.publishment'))->ucfirst(),
                    'updated_at' => Str::of(__('validation.attributes.updated_at'))->ucfirst(),
                    'order'      => Str::of(__('validation.custom.order'))->ucfirst(),
                ],
            ])
        </thead>
        <tbody>
            @foreach ($tagModels as $tagModel)
            <tr class="border-bottom">
                <td class="text-center align-middle">{{ $tagModel->name }}</td>
                @include('back.modules.change-published-status', [
                    'routeName' => 'tags',
                    'model'     => $tagModel
                ])
                <td class="text-center align-middle">
                    <span class="badge bg-secondary">{{ $tagModel->updated_at->isoFormat('LLLL') }}</span>
                </td>
                @php $routeName = request()->route()->getName(); @endphp
                @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
                @include('back.modules.change-model-order', [
                    'routeName' => 'tags',
                    'models'    => $tagModels,
                    'model'     => $tagModel
                ])
                @endif
                <td class="text-end align-middle">
                    @canAny(['delete', 'duplicate', 'update'], $tagModel)
                    <form action="{{ route('bo.tags.destroy', $tagModel) }}"
                        method="POST"
                        class="btn-group confirmDeleteTS"
                        novalidate>
                        @can('duplicate', $tagModel)
                        <a class="btn btn-sm btn-secondary"
                            href="{{ route('bo.tags.duplicate', ['tag' => $tagModel]) }}"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.duplicate', ['model' => __('models.tag')]) }}">
                            <i class="fa-solid fa-copy"></i>
                        </a>
                        @endcan
                        @can('update', $tagModel)
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('bo.tags.edit', ['tag' => $tagModel]) }}"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.edit', ['model' => __('models.tag')]) }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        @endcan
                        @can('delete', $tagModel)
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-sm btn-danger"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.delete', ['model' => __('models.tag')]) }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @endcan
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
            <td class="border-0">{{ __('crud.other.no_model_found', ['model' => __('models.tag')]) }}</td>
        </tr>
        @endif
    </table>
</div>
{!! $tagModels->links() !!}
@endsection
