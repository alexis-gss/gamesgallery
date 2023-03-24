@extends('layouts.backend')

@section('title', __('meta.all_games'))
@section('description', __('meta.all_games_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 border-top border-bottom">
        <h1 class="h2 m-0 fw-bold">{{ __('list.games') }} <small class="text-muted h4">{{ __('list.list') }}</small></h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="float-center text-danger">{{ $error }}</span>
            @endforeach
        @endif
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
        class="d-flex flex-row input-group pt-3">
        <input class="form-control"
            type="text"
            placeholder="{{ __('search.search_game') }}"
            id="search"
            name="search"
            value="{{ old('search', $search ?? '') }}">
        @include('back.modules.select-folder', ['type' => 'filter', 'target' => $filter])
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
                <tr>
                    <th scope="col" class="col-3">{{ __('list.name') }}</th>
                    <th scope="col" class="d-none d-lg-table-cell col-3">{{ __('list.folder_associated') }}</th>
                    <th scope="col" class="d-none d-xxl-table-cell col-3">{{ __('list.tags') }}</th>
                    <th scope="col" class="d-none d-md-table-cell col-1 text-center">{{ __('list.images') }}</th>
                    @can('isAdmin')
                        <th scope="col" class="d-none d-xl-table-cell col-1 text-center">{{ __('list.publishment') }}</th>
                        @if (count($games) > 1)
                            <th scope="col" class="d-none d-sm-table-cell col-1 text-center">{{ __('list.order') }}</th>
                        @endif
                        <th scope="col" class="col-1"><!-- Empty --></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr class="list-item border-bottom">
                        <td class="align-middle">
                            <p class="col-10 text-truncate m-0">{{ $game->name }}</p>
                        </td>
                        <td class="d-none d-lg-table-cell align-middle text-secondary">
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
                        <td class="d-none d-xxl-table-cell align-middle">
                            @if (count($game->tags) > 0)
                                @foreach($game->tags as $tag)
                                    @can('isAdmin')
                                        <a href="{{ route('bo.tags.edit', ['tag' => $tag->id]) }}"
                                            data-bs="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('list.show_tag') }}"
                                            class="text-decoration-none">
                                        @endcan
                                            <div class="badge bg-primary d-inline-block text-white rounded-2">
                                                {{ $tag->name }}
                                            </div>
                                        @can('isAdmin')
                                        </a>
                                    @endcan
                                @endforeach
                            @else
                                <p class="m-0">{{ __('list.no_associated_tag') }}</p>
                            @endif
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
                                        class="btn btn-sm d-flex mx-auto"
                                        title="{{ __($game->status ? __('list.unpublish') : __('list.publish')) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top">
                                        @if($game->status)
                                            <i class="fa-solid fa-circle-check text-primary"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            @if ($loop->count > 1)
                                <td class="d-none d-sm-table-cell border-0">
                                    <div class="d-flex justify-content-center">
                                        @if(!($loop->first and $games->onFirstPage()))
                                            <a href="{{ route('bo.games.change-order', ['game' => $game, 'direction' => 'up']) }}"
                                                class="btn d-flex btn-link w-fit"
                                                data-bs="tooltip"
                                                data-bs-placement="top"
                                                title="{{ __('list.up') }}">
                                                <i class="fa-solid fa-circle-arrow-up"></i>
                                            </a>
                                        @endif
                                        @if (!($loop->last and $games->currentPage() === $games->lastPage()))
                                            <a href="{{ route('bo.games.change-order', ['game' => $game, 'direction' => 'down']) }}"
                                                class="btn d-flex btn-link w-fit"
                                                data-bs="tooltip"
                                                data-bs-placement="top"
                                                title="{{ __('list.down') }}">
                                                <i class="fa-solid fa-circle-arrow-down"></i>
                                            </a>
                                        @endif
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
