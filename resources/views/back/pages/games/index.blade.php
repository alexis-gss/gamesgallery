@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => __('models.games')]))
@section('description', __('crud.meta.all_models_list', ['model' => __('models.games')]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('isAdmin')
    <a href="{{ route('bo.games.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('crud.actions_model.create', ['model' => Str::singular(__('models.games'))]) }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<div class="table-responsive mb-3">
    <table class="table table-hover table-fix-action m-0">
        @if (count($games) > 0)
        <thead>
            @include('back.modules.table-col-sorter', [
                'cols' => [
                    'name'       => __('validation.attributes.name'),
                    'folder_id'  => __('validation.attributes.folder_associated'),
                    'pictures'   => __('validation.attributes.images'),
                    'published'  => __('validation.attributes.publishment'),
                    'updated_at' => __('validation.attributes.updated_at'),
                    'order'      => __('validation.attributes.order')
                ],
                'ignore' => ['pictures'],
            ])
        </thead>
        <tbody>
            @foreach ($games as $game)
            <tr class="border-bottom">
                <td class="text-center align-middle">
                    <p class="col-10 text-truncate m-0">{{ $game->name }}</p>
                </td>
                <td class="align-middle text-center text-secondary">
                    @can('isAdmin')
                    <a href="{{ route('bo.folders.edit', ['folder' => $game->folder_id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('texts.bo.tooltip.show_folder') }}"
                        class="text-decoration-none">
                    @endcan
                    <span class="@can('isAdmin') badge bg-primary @endcan">
                        {{ $game->folder->name }}
                    </span>
                    @can('isAdmin')
                    </a>
                    @endcan
                </td>
                <td class="text-center align-middle">
                    @if (isset($game->pictures) && count($game->pictures) > 0)
                    {{ count($game->pictures) }}
                    @else
                    <p class="m-0">0</p>
                    @endif
                </td>
                @include('back.modules.change-published-status', [
                    'routeName' => 'games',
                    'model'     => $game
                ])
                <td class="text-center align-middle">
                    <span class="badge bg-secondary">{{ $game->updated_at }}</span>
                </td>
                @php $routeName = request()->route()->getName(); @endphp
                @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
                @include('back.modules.change-model-order', [
                    'routeName' => 'games',
                    'models'    => $games,
                    'model'     => $game
                ])
                @endif
                <td class="text-end align-middle">
                    @can('isAdmin')
                    <form action="{{ route('bo.games.destroy', $game->id) }}"
                        method="POST"
                        class="btn-group confirmDeleteTS"
                        novalidate>
                        @if ($game->published)
                        <a href="{{ route('fo.games.specific', $game->slug) }}"
                            class="btn btn-sm btn-warning"
                            target="_blank"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.show', ['model' => Str::singular(__('models.games'))]) }}">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        @endif
                        <a class="btn btn-sm btn-secondary"
                            href="{{ route('bo.games.duplicate', ['game' => $game->id]) }}"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.duplicate', ['model' => Str::singular(__('models.games'))]) }}">
                            <i class="fa-solid fa-copy"></i>
                        </a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('bo.games.edit', ['game' => $game->id]) }}"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.edit', ['model' => Str::singular(__('models.games'))]) }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            type="submit"
                            data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('crud.actions_model.delete', ['model' => Str::singular(__('models.games'))]) }}">
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
            <td class="border-0">{{ __('crud.other.no_model_found', ['model' => Str::singular(__('models.games'))]) }}</td>
        </tr>
        @endif
    </table>
</div>
{!! $games->links() !!}
@endsection
