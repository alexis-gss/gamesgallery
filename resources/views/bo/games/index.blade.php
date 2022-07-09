@extends('layouts.backend')

@section('title', __('Games'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
        <h1 class="h2 m-0">{{ __('Games') }} <small class="text-muted">{{ __('List') }}</small></h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="float-center text-danger">{{ $error }}</span>
            @endforeach
        @endif
        <form action="{{ route('bo.games.search') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-row">
            @csrf
            <input class="form-control" type="text" title="{{ __('Search_game') }}"
                placeholder="{{ __('Search_game') }}" id="filter" name="filter"
                value="{{ old('filter', $filter ?? '') }}">
            <button class="btn btn-primary mx-2" title="{{ __('Apply_filter') }}">{{ __('Filtered') }}</button>
            <a class="btn btn-info" title="{{ __('Remove_filter') }}"
                href="{{ route('bo.games.index') }}">{{ __('No_filter') }}</a>
        </form>
        @can('isAdmin')
            <a href="{{ route('bo.games.create') }}" class="btn btn-primary float-right"
                title="{{ __('Create_new_game') }}">{{ __('Create_a_game') }}</a>
        @endcan
    </div>
    <table class="table">
        @if (count($games) > 0)
            <thead class="thead-dark">
                <tr>
                    <th scope="col" class="w-25">{{ __('Name') }}</th>
                    <th scope="col" class="w-25">{{ __('Folder_associated') }}</th>
                    <th scope="col" class="w-test">{{ __('Images') }}</th>
                    @can('isAdmin')
                        @if (count($games) > 1)
                            <th scope="col" class="w-test px-4">{{ __('Order') }}</th>
                        @endif
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr>
                        <td class="w-25">{{ $game->name }}</td>
                        <td class="w-25 text-secondary">
                            @if (isset($game->folder_id))
                                @can('isAdmin')
                                    <a href="{{ route('bo.folders.edit', ['folder' => $game->folder_id]) }}"
                                        title="{{ __('Show_folder') }}">
                                    @endcan
                                    {{ $game->folder->name }}
                                    @can('isAdmin')
                                    </a>
                                @endcan
                            @else
                                No associated folder
                            @endif
                        </td>
                        <td class="w-test">
                            @if (isset($game->pictures) && count($game->pictures) > 0)
                                {{ count($game->pictures) }}
                            @else
                                0
                            @endif
                        </td>
                        @can('isAdmin')
                            @if ($loop->count > 1)
                                <td class="w-test">
                                    @if ($loop->first)
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none px-3" title="{{ __('Down') }}">
                                            ↓
                                        </a>
                                    @elseif($loop->last)
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none px-3" title="{{ __('Up') }}">
                                            ↑
                                        </a>
                                    @else
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none px-3" title="{{ __('Up') }}">
                                            ↑
                                        </a>
                                        <a href="{{ route('bo.games.change-order', ['game' => $game->id, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none px-3" title="{{ __('Down') }}">
                                            ↓
                                        </a>
                                    @endif
                                </td>
                            @endif
                            <td class="w-test px-0 ta-end">
                                <a href="{{ route('bo.games.edit', ['game' => $game->id]) }}"
                                    class="btn btn-sm btn-primary mx-1"
                                    title="{{ __('Edit_game') }}">{{ __('Edit') }}</a>
                                <form action="{{ route('bo.games.destroy', $game->id) }}" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" class="btn btn-sm btn-danger" value="{{ __('Delete') }}"
                                        title="{{ __('Delete_game') }}"
                                        onclick="return confirm(`{{ __('Are_you_sure') }}`)">
                                </form>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        @else
            <tr>
                <td class="w-25 border-0">No games found</td>
            </tr>
        @endif
    </table>
    {!! $games->links() !!}
@endsection
