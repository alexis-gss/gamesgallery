@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => trans_choice('models.game', 2)]))
@section('description', __('crud.meta.all_models_list', ['model' => trans_choice('models.game', 2)]))

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        @include('breadcrumbs.breadcrumb-body')
        @can('create', \App\Models\Game::class)
            <a class="btn btn-primary float-right" data-bs-tooltip="tooltip" data-bs-placement="top" href="{{ route('bo.games.create') }}"
                title="{{ __('crud.actions_model.create', ['model' => trans_choice('models.game', 1)]) }}">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    @include('back.modules.search-bar')
    <div class="table-responsive mb-3">
        <table class="table-hover table-fix-action m-0 table">
            @if (count($gameModels) > 0)
                <thead>
                    @include('back.modules.table-col-sorter', [
                        'cols' => [
                            'name' => Str::of(__('validation.attributes.name'))->ucfirst(),
                            'folder_id' => Str::of(__('validation.custom.folder_associated'))->ucfirst(),
                            'pictures' => Str::of(__('validation.attributes.image'))->ucfirst(),
                            'published' => Str::of(__('validation.custom.publishment'))->ucfirst(),
                            'updated_at' => Str::of(__('validation.attributes.updated_at'))->ucfirst(),
                            'order' => Str::of(__('validation.custom.order'))->ucfirst(),
                        ],
                        'ignore' => ['pictures'],
                    ])
                </thead>
                <tbody>
                    @foreach ($gameModels as $gameModel)
                        <tr class="border-bottom">
                            <td class="text-center align-middle">
                                <p class="col-10 text-truncate m-0">{{ $gameModel->name }}</p>
                            </td>
                            <td class="text-secondary text-center align-middle">
                                @can('update', $gameModel)
                                    <a class="text-decoration-none" data-bs-tooltip="tooltip" data-bs-placement="top"
                                        href="{{ route('bo.folders.edit', ['folder' => $gameModel->folder_id]) }}"
                                        title="{{ __('bo_tooltip_show_folder') }}">
                                    @endcan
                                    <span class="@can('update', $gameModel) badge bg-primary @else text-body @endcan">
                                        {{ $gameModel->folder->name }}
                                    </span>
                                    @can('update', $gameModel)
                                    </a>
                                @endcan
                            </td>
                            <td class="text-center align-middle">
                                <p class="m-0">
                                    {{ isset($gameModel->pictures) && count($gameModel->pictures) ? count($gameModel->pictures) : 0 }}</p>
                            </td>
                            @include('back.modules.change-published-status', [
                                'routeName' => 'games',
                                'model' => $gameModel,
                            ])
                            <td class="text-center align-middle">
                                <span class="badge bg-secondary">{{ $gameModel->updated_at->isoFormat('LLLL') }}</span>
                            </td>
                            @php $routeName = request()->route()->getName(); @endphp
                            @if (empty(request()->search) && Session::get("$routeName.sort_col") === 'order')
                                @include('back.modules.change-model-order', [
                                    'routeName' => 'games',
                                    'models' => $gameModels,
                                    'model' => $gameModel,
                                ])
                            @endif
                            <td class="text-end align-middle">
                                @canAny(['delete', 'duplicate', 'update', 'view'], $gameModel)
                                    <form class="btn-group confirmActionTS" data-message="{{ __('crud.sweetalert.data_lost') }}"
                                        action="{{ route('bo.games.destroy', $gameModel) }}" method="POST" novalidate>
                                        @if ($gameModel->published)
                                            @can('view', $gameModel)
                                                <a class="btn btn-sm btn-warning" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                    href="{{ route('fo.games.show', $gameModel->slug) }}"
                                                    title="{{ __('crud.actions_model.show', ['model' => trans_choice('models.game', 1)]) }}"
                                                    target="_blank">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endcan
                                        @endif
                                        @can('duplicate', $gameModel)
                                            <a class="btn btn-sm btn-secondary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.games.duplicate', ['game' => $gameModel]) }}"
                                                title="{{ __('crud.actions_model.duplicate', ['model' => trans_choice('models.game', 1)]) }}">
                                                <i class="fa-solid fa-copy"></i>
                                            </a>
                                        @endcan
                                        @can('update', $gameModel)
                                            <a class="btn btn-sm btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.games.edit', ['game' => $gameModel]) }}"
                                                title="{{ __('crud.actions_model.edit', ['model' => trans_choice('models.game', 1)]) }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $gameModel)
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                                                title="{{ __('crud.actions_model.delete', ['model' => trans_choice('models.game', 1)]) }}">
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
                    <td class="border-0">{{ __('crud.other.no_model_found', ['model' => trans_choice('models.game', 1)]) }}</td>
                </tr>
            @endif
        </table>
    </div>
    {!! $gameModels->links() !!}
@endsection
