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
        @can('isAdmin')
            <a href="{{ route('bo.games.create') }}" class="btn btn-primary float-right" data-bs="tooltip" data-bs-placement="top"
                title="{{ __('list.create_new_game') }}">
                <svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill"
                    viewBox="0 0 448 512">
                    <path
                        d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z" />
                </svg>
            </a>
        @endcan
    </div>
    @include('back.modules.search', [
        'routeSearch' => 'bo.games.search',
        'routeIndex' => 'bo.games.index',
        'target' => $games,
    ])
    <table class="table">
        @if (count($games) > 0)
            <thead class="thead-dark">
                <tr>
                    <th scope="col">{{ __('list.name') }}</th>
                    <th scope="col">{{ __('list.folder_associated') }}</th>
                    <th scope="col">{{ __('list.images') }}</th>
                    @can('isAdmin')
                        @if (count($games) > 1)
                            <th scope="col">{{ __('list.order') }}</th>
                        @endif
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr class="list_item">
                        <td class="w-22">{{ $game->name }}</td>
                        <td class="w-22 text-secondary">
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
                        <td>
                            @if (isset($game->pictures) && count($game->pictures) > 0)
                                {{ count($game->pictures) }}
                            @else
                                0
                            @endif
                        </td>
                        @can('isAdmin')
                            @if ($loop->count > 1)
                                <td>
                                    @if ($loop->first)
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none" data-bs="tooltip" data-bs-placement="top"
                                            title="{{ __('list.down') }}">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-down"
                                                viewBox="0 0 384 512">
                                                <path
                                                    d="M374.6 310.6l-160 160C208.4 476.9 200.2 480 192 480s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 370.8V64c0-17.69 14.33-31.1 31.1-31.1S224 46.31 224 64v306.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0S387.1 298.1 374.6 310.6z" />
                                            </svg>
                                        </a>
                                    @elseif($loop->last)
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none" data-bs="tooltip" data-bs-placement="top"
                                            title="{{ __('list.up') }}">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-down"
                                                viewBox="0 0 384 512">
                                                <path
                                                    d="M374.6 246.6C368.4 252.9 360.2 256 352 256s-16.38-3.125-22.62-9.375L224 141.3V448c0 17.69-14.33 31.1-31.1 31.1S160 465.7 160 448V141.3L54.63 246.6c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0l160 160C387.1 213.9 387.1 234.1 374.6 246.6z" />
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none" data-bs="tooltip" data-bs-placement="top"
                                            title="{{ __('list.up') }}">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-down"
                                                viewBox="0 0 384 512">
                                                <path
                                                    d="M374.6 246.6C368.4 252.9 360.2 256 352 256s-16.38-3.125-22.62-9.375L224 141.3V448c0 17.69-14.33 31.1-31.1 31.1S160 465.7 160 448V141.3L54.63 246.6c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0l160 160C387.1 213.9 387.1 234.1 374.6 246.6z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none" data-bs="tooltip" data-bs-placement="top"
                                            title="{{ __('list.down') }}">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-down"
                                                viewBox="0 0 384 512">
                                                <path
                                                    d="M374.6 310.6l-160 160C208.4 476.9 200.2 480 192 480s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 370.8V64c0-17.69 14.33-31.1 31.1-31.1S224 46.31 224 64v306.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0S387.1 298.1 374.6 310.6z" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                            @endif
                            <td class="ta-end">
                                <form action="{{ route('bo.games.destroy', $game->id) }}" method="POST" class="btn-group"
                                    novalidate
                                    onsubmit="popupDelete(event, 
                                    '{{ __('list.are_you_sure') }}', 
                                    '{{ __('list.data_lost', ['item' => $game->name]) }}', 
                                    '{{ __('list.form_confirm') }}')">
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('bo.games.edit', ['game' => $game->id]) }}" data-bs="tooltip"
                                        data-bs-placement="top" title="{{ __('list.edit_game') }}">
                                        <svg width="16" height="16" fill="currentColor" class="bi bi-pencil-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-bs="tooltip"
                                        data-bs-placement="top" title="{{ __('list.delete_game') }}">
                                        <svg width="16" height="16" fill="currentColor" class="bi bi-trash3-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
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
                <td class="border-0">{{ __('list.no_games_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $games->links() !!}
@endsection
