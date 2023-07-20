@extends('layouts.backend')

@section('title', __('meta.all_games'))
@section('description', __('meta.all_games_desc'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('isAdmin')
    <a href="{{ route('bo.games.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('list.create_new_game') }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<table class="table table-hover">
    @if (count($games) > 0)
    <thead>
        @php
        $cols = [
            'name' => __('list.name'),
            'folder_id' => __('list.folder_associated'),
            'pictures' => __('list.images'),
            'published' => __('list.publishment'),
            'order' => __('list.order')
        ];
        @endphp
        @include('back.modules.table-col-sorter', [
            'cols' => $cols,
            'mobileHide' => [],
            'ignore' => ['pictures'],
        ])
    </thead>
    <tbody>
        @foreach ($games as $game)
        <tr class="border-bottom">
            <td class="text-center align-middle">
                <p class="col-10 text-truncate m-0">{{ $game->name }}</p>
            </td>
            <td class="d-none d-lg-table-cell align-middle text-center text-secondary">
                @can('isAdmin')
                <a href="{{ route('bo.folders.edit', ['folder' => $game->folder_id]) }}"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('list.show_folder') }}"
                    class="text-decoration-none">
                @endcan
                <span class="@can('isAdmin') badge bg-primary d-inline-block text-white rounded-2 @else text-dark @endcan">
                    {{ $game->folder->name }}
                </span>
                @can('isAdmin')
                </a>
                @endcan
            </td>
            <td class="d-none d-md-table-cell text-center align-middle">
                @if (isset($game->pictures) && count($game->pictures) > 0)
                {{ count($game->pictures) }}
                @else
                <p class="m-0">0</p>
                @endif
            </td>
            @include('back.modules.change-published-status', [
                'routeName' => 'games',
                'model' => $game
            ])
            @php $routeName = request()->route()->getName(); @endphp
            @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
            @include('back.modules.change-model-order', [
                'routeName' => 'games',
                'models' => $games,
                'model' => $game
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
                        title="{{ __('list.show_game') }}">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    @endif
                    <a class="btn btn-sm btn-secondary"
                        href="{{ route('bo.games.duplicate', ['game' => $game->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.duplicate_game') }}">
                        <i class="fa-solid fa-copy"></i>
                    </a>
                    <a class="btn btn-sm btn-primary"
                        href="{{ route('bo.games.edit', ['game' => $game->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.edit_game') }}">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                        type="submit"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.delete_game') }}">
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
        <td class="border-0">{{ __('list.no_games_found') }}</td>
    </tr>
    @endif
</table>
{!! $games->links() !!}
@endsection
