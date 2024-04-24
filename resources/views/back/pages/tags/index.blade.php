@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => str(__('models.tag'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => str(__('models.tag'))->plural()]))

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        @include('breadcrumbs.breadcrumb-body')
        @can('create', \App\Models\Tag::class)
            <a class="btn btn-primary float-right" data-bs-tooltip="tooltip" data-bs-placement="top" href="{{ route('bo.tags.create') }}"
                title="{{ __('crud.actions_model.create', ['model' => __('models.tag')]) }}">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    @include('back.modules.search-bar')
    <div class="table-responsive mb-3">
        <table class="table-hover table-fix-action m-0 table">
            @if (count($tagModels) > 0)
                <thead>
                    @include('back.modules.table-col-sorter', [
                        'cols' => [
                            'name' => str(__('validation.attributes.name'))->ucfirst(),
                            'published' => str(__('validation.custom.publishment'))->ucfirst(),
                            'updated_at' => str(__('validation.attributes.updated_at'))->ucfirst(),
                            'order' => str(__('validation.custom.order'))->ucfirst(),
                        ],
                    ])
                </thead>
                <tbody>
                    @foreach ($tagModels as $tagModel)
                        <tr class="border-bottom">
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    @foreach (config('app.locales') as $locale)
                                        <span @class([
                                            'fst-italic text-body-secondary' =>
                                                $locale !== config('app.fallback_locale'),
                                        ])>
                                            {{ $tagModel->getTranslation('name', $locale) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            @include('back.modules.change-published-status', [
                                'routeName' => 'tags',
                                'model' => $tagModel,
                            ])
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-secondary">{{ $tagModel->updated_at->isoFormat('LLLL') }}</span>
                            </td>
                            @php $routeName = request()->route()->getName(); @endphp
                            @if (empty(request()->search) && session()->get("$routeName.sort_col") === 'order')
                                @include('back.modules.change-model-order', [
                                    'routeName' => 'tags',
                                    'models' => $tagModels,
                                    'model' => $tagModel,
                                ])
                            @endif
                            <td class="text-end align-middle">
                                @canAny(['view', 'duplicate', 'update', 'delete'], $tagModel)
                                    <form class="btn-group confirmActionTS" data-message="{{ __('crud.sweetalert.data_lost') }}"
                                        action="{{ route('bo.tags.destroy', $tagModel) }}" method="POST" novalidate>
                                        @can('view', $tagModel)
                                            <a class="btn btn-sm btn-warning" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.tags.show', $tagModel) }}"
                                                title="{{ __('crud.actions_model.show', ['model' => __('models.tag')]) }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('duplicate', $tagModel)
                                            <a class="btn btn-sm btn-secondary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.tags.duplicate', ['tag' => $tagModel]) }}"
                                                title="{{ __('crud.actions_model.duplicate', ['model' => __('models.tag')]) }}">
                                                <i class="fa-solid fa-copy"></i>
                                            </a>
                                        @endcan
                                        @can('update', $tagModel)
                                            <a class="btn btn-sm btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.tags.edit', ['tag' => $tagModel]) }}"
                                                title="{{ __('crud.actions_model.edit', ['model' => __('models.tag')]) }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $tagModel)
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
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
