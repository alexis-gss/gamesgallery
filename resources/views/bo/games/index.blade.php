@extends('layouts.backend')

@section('title', __('meta.all_games'))
@section('description', __('meta.all_games_desc'))
@section('metaIndex', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
        <h1 class="h2 m-0 fw-bold">{{ __('list.games') }} <small class="text-muted h4">{{ __('list.list') }}</small></h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="float-center text-danger">{{ $error }}</span>
            @endforeach
        @endif
        @if (count($games) > 1 || Route::is('bo.games.search'))
            <form action="{{ route('bo.games.search') }}" method="POST" enctype="multipart/form-data" id="filter"
                class="d-flex flex-row">
                @csrf
                <input class="form-control" type="text" data-bs="tooltip" data-bs-placement="top"
                    title="{{ __('filter.search_game') }}" placeholder="{{ __('filter.search_game') }}" id="filter"
                    name="filter" value="{{ old('filter', $filter ?? '') }}" required>
                <button class="btn btn-primary" type="submit" data-bs="tooltip" data-bs-placement="top"
                    title="{{ __('filter.apply_filter') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
                <a class="btn btn-danger @if (Route::is('bo.games.search')) visible @else invisible @endif" data-bs="tooltip"
                    data-bs-placement="top" title="{{ __('filter.remove_filter') }}" href="{{ route('bo.games.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path
                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                </a>
            </form>
        @endif
        @can('isAdmin')
            <a href="{{ route('bo.games.create') }}" class="btn btn-primary float-right" data-bs="tooltip"
                data-bs-placement="top" title="{{ __('list.create_new_game') }}">{{ __('list.create_a_game') }}</a>
        @endcan
    </div>
    <table class="table">
        @if (count($games) > 0)
            <thead class="thead-dark">
                <tr>
                    <th scope="col" class="w-25">{{ __('list.name') }}</th>
                    <th scope="col" class="w-25">{{ __('list.folder_associated') }}</th>
                    <th scope="col" class="w-2">{{ __('list.images') }}</th>
                    @can('isAdmin')
                        @if (count($games) > 1)
                            <th scope="col" class="w-2">{{ __('list.order') }}</th>
                        @endif
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr class="list_item">
                        <td class="w-25">{{ $game->name }}</td>
                        <td class="w-25 text-secondary">
                            @if (isset($game->folder_id))
                                @can('isAdmin')
                                    <a href="{{ route('bo.folders.edit', ['folder' => $game->folder_id]) }}" data-bs="tooltip"
                                        data-bs-placement="top" title="{{ __('list.show_folder') }}"
                                        class="text-decoration-none">
                                    @endcan
                                    {{ $game->folder->name }}
                                    @can('isAdmin')
                                    </a>
                                @endcan
                            @else
                                {{ __('list.no_associated_folder') }}
                            @endif
                        </td>
                        <td class="w-2">
                            @if (isset($game->pictures) && count($game->pictures) > 0)
                                {{ count($game->pictures) }}
                            @else
                                0
                            @endif
                        </td>
                        @can('isAdmin')
                            @if ($loop->count > 1)
                                <td class="w-2">
                                    @if ($loop->first)
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none" data-bs="tooltip" data-bs-placement="top"
                                            title="{{ __('list.down') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                            </svg>
                                        </a>
                                    @elseif($loop->last)
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none" data-bs="tooltip" data-bs-placement="top"
                                            title="{{ __('list.up') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none" data-bs="tooltip" data-bs-placement="top"
                                            title="{{ __('list.up') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none" data-bs="tooltip" data-bs-placement="top"
                                            title="{{ __('list.down') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                            @endif
                            <td class="w-2 px-0 ta-end">
                                <a href="{{ route('bo.games.edit', ['game' => $game->id]) }}"
                                    class="btn btn-sm btn-primary mx-1" data-bs="tooltip" data-bs-placement="top"
                                    title="{{ __('list.edit_game') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                        <path
                                            d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                    </svg>
                                </a>
                                <form action="{{ route('bo.games.destroy', $game->id) }}" method="POST" class="d-inline"
                                    onsubmit="popupDelete(event, 
                                    '{{ __('list.are_you_sure') }}', 
                                    '{{ __('list.data_lost', ['item' => $game->name]) }}', 
                                    '{{ __('list.form_confirm') }}')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" data-bs="tooltip"
                                        data-bs-placement="top" title="{{ __('list.delete_game') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        @else
            <tr>
                <td class="w-25 border-0">{{ __('list.no_games_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $games->links() !!}
@endsection
