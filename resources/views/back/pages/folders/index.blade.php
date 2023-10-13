@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => Str::of(__('models.folder'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => Str::of(__('models.folder'))->plural()]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('create', \App\Models\Folder::class)
    <a href="{{ route('bo.folders.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('crud.actions_model.create', ['model' => __('models.folder')]) }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<div class="table-responsive mb-3">
    <table class="table table-hover table-fix-action m-0">
        @if (count($folderModels) > 0)
        <thead>
            @include('back.modules.table-col-sorter', [
                'cols' => [
                    'name'       => Str::of(__('validation.attributes.name'))->ucfirst(),
                    'color'      => Str::of(__('validation.custom.color'))->ucfirst(),
                    'published'  => Str::of(__('validation.custom.publishment'))->ucfirst(),
                    'updated_at' => Str::of(__('validation.attributes.updated_at'))->ucfirst(),
                    'order'      => Str::of(__('validation.custom.order'))->ucfirst(),
                ],
            ])
        </thead>
        <tbody>
            @foreach ($folderModels as $folderModel)
            <tr class="border-bottom">
                <td class="text-center align-middle">{{ $folderModel->name }}</td>
                <td class="text-center align-middle">
                    <div class="btn-sm preview-color mx-auto"
                        title="{{ __('texts.bo.tooltip.color_details', ['color' => $folderModel->color]) }}"
                        data-bs="tooltip">
                        <span class="d-block w-100 h-100 rounded-1" style="background-color:{{ $folderModel->color }}"></span>
                    </div>
                </td>
                @include('back.modules.change-published-status', [
                    'routeName' => 'folders',
                    'model'     => $folderModel
                ])
                <td class="text-center align-middle">
                    <span class="badge bg-secondary">{{ $folderModel->updated_at->isoFormat('LLLL') }}</span>
                </td>
                @php $routeName = request()->route()->getName(); @endphp
                @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
                @include('back.modules.change-model-order', [
                    'routeName' => 'folders',
                    'models'    => $folderModels,
                    'model'     => $folderModel
                ])
                @endif
                <td class="text-end align-middle">
                    @canAny(['delete', 'duplicate', 'update'], $folderModel)
                    <form action="{{ route('bo.folders.destroy', $folderModel) }}"
                        method="POST"
                        class="btn-group confirmDeleteTS"
                        novalidate>
                        @can('duplicate', $folderModel)
                        <a class="btn btn-sm btn-secondary"
                            href="{{ route('bo.folders.duplicate', ['folder' => $folderModel]) }}"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.duplicate', ['model' => __('models.folder')]) }}">
                            <i class="fa-solid fa-copy"></i>
                        </a>
                        @endcan
                        @can('update', $folderModel)
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('bo.folders.edit', ['folder' => $folderModel]) }}"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.edit', ['model' => __('models.folder')]) }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        @endcan
                        @can('delete', $folderModel)
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-sm btn-danger"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.delete', ['model' => __('models.folder')]) }}">
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
            <td class="border-0">{{ __('crud.other.no_model_found', ['model' => __('models.folder')]) }}</td>
        </tr>
        @endif
    </table>
</div>
{!! $folderModels->links() !!}
@endsection
