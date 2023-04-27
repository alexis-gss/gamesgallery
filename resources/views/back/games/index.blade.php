@extends('layouts.backend')

@section('title', __('meta.all_games'))
@section('description', __('meta.all_games_desc'))
@section('keywords', 'noindex,nofollow')

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
    <form action="{{ request()->url() }}" enctype="multipart/form-data" id="search"
        class="d-flex flex-row input-group pt-3 pb-2">
        <label class="input-group-text" for="searchField">{{ $searchFields }}</label>
        <input class="form-control"
            type="text"
            placeholder="{{ __('search.search_game') }}"
            id="searchField"
            name="search"
            value="{{ old('search', $search ?? '') }}">
        <button class="btn btn-primary"
            type="submit"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('search.apply_search') }}">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <a class="btn btn-danger"
            data-bs="tooltip"
            data-bs-placement="top"
            title="{{ __('search.remove_search') }}"
            href="{{ route('bo.games.index') }}">
            <i class="fa-solid fa-delete-left"></i>
        </a>
    </form>
    <table class="table">
        @if (count($games) > 0)
            <thead>
                @php
                $rst = !is_null(request()->rst);
                $routeName = request()->route()->getName();
                $noOrder = Session::get("$routeName.sort_col") !== 'order' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $noOrder = Session::get("$routeName.sort_col") !== '' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $cols = [
                    'name' => __('list.name'),
                    'folder_id' => __('list.folder_associated'),
                    'pictures' => __('list.images'),
                    'status' => __('list.publishment'),
                    'order' => __('list.order')
                ];
                @endphp
                @include('back.modules.table-col-sorter', [
                    'cols' => $cols,
                    'mobileHide' => [],
                ])
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr class="list-item border-bottom">
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
                                    <div class="badge bg-primary d-inline-block text-white rounded-2">
                                        {{ $game->folder->name }}
                                    </div>
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
                        @can('isAdmin')
                            <td class="d-none d-xl-table-cell text-center align-middle">
                                <form action="{{ route('bo.games.change-published', $game->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm @if($game->status) btn-primary @else btn-danger @endif"
                                        title="{{ __($game->status ? __('list.unpublish') : __('list.publish')) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top">
                                        @if($game->status)
                                            <i class="fa-solid fa-circle-check"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            @if(!$noOrder or $rst)
                            <td class="align-middle">
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('bo.games.change-order', ['game' => $game, 'direction' => 'up']) }}"
                                        class="@if($loop->first and $games->onFirstPage()) invisible @endif">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-dark @if(($loop->first and $games->onFirstPage())) disabled @endif"
                                            title="{{ __('list.up') }}"
                                            data-bs="tooltip">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('bo.games.change-order', ['game' => $game, 'direction' => 'down']) }}"
                                        class="@if($loop->last and $games->currentPage() === $games->lastPage()) invisible @endif">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-dark ms-1 @if($loop->last and $games->currentPage() === $games->lastPage()) disabled @endif"
                                            title="{{ __('list.down') }}"
                                            data-bs="tooltip">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            @endif
                            <td class="text-end align-middle">
                                <form action="{{ route('bo.games.destroy', $game->id) }}"
                                    method="POST"
                                    class="btn-group confirmDeleteTS"
                                    novalidate>
                                    @if ($game->status)
                                        <a href="{{ route('fo.games.specific', $game->slug) }}"
                                            class="btn btn-sm btn-warning"
                                            target="_blank"
                                            data-bs="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('list.show_game') }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    @endif
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
                            </td>
                        @endcan
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
