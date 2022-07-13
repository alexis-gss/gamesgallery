@extends('layouts.backend')

@section('title', __('Folders'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
        <h1 class="h2 m-0 fw-bold">{{ __('list.folders') }} <small class="text-muted h4">{{ __('list.list') }}</small>
        </h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="float-center text-danger">{{ $error }}</span>
            @endforeach
        @endif
        <form action="{{ route('bo.folders.search') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-row">
            @csrf
            <input class="form-control" type="text" title="{{ __('filter.search_folder') }}"
                placeholder="{{ __('filter.search_folder') }}" id="filter" name="filter"
                value="{{ old('filter', $filter ?? '') }}">
            <button class="btn btn-primary mx-2" type="submit"
                title="{{ __('filter.apply_filter') }}">{{ __('filter.filtered') }}</button>
            <a class="btn btn-info" title="{{ __('filter.remove_filter') }}"
                href="{{ route('bo.folders.index') }}">{{ __('filter.no_filter') }}</a>
        </form>
        @can('isAdmin')
            <a href="{{ route('bo.folders.create') }}" class="btn btn-primary float-right"
                title="{{ __('list.create_new_folder') }}">{{ __('list.create_a_folder') }}</a>
        @endcan
    </div>
    <table class="table">
        @if (count($folders) > 0)
            <thead class="thead-dark">
                <tr>
                    <th scope="col" class="w-25">{{ __('list.name') }}</th>
                    @can('isAdmin')
                        @if (count($folders) > 1)
                            <th scope="col" class="w-10 px-4">{{ __('list.order') }}</th>
                        @endif
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($folders as $folder)
                    <tr>
                        <td class="w-25">{{ $folder->name }}</td>
                        @can('isAdmin')
                            @if ($loop->count > 1)
                                <td class="w-10">
                                    @if ($loop->first)
                                        <a href="{{ route('bo.folders.change-order', ['folder' => $folder->id, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none px-3" title="{{ __('list.down') }}">
                                            ↓
                                        </a>
                                    @elseif($loop->last)
                                        <a href="{{ route('bo.folders.change-order', ['folder' => $folder->id, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none px-3" title="{{ __('list.up') }}">
                                            ↑
                                        </a>
                                    @else
                                        <a href="{{ route('bo.folders.change-order', ['folder' => $folder->id, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none px-3" title="{{ __('list.up') }}">
                                            ↑
                                        </a>
                                        <a href="{{ route('bo.folders.change-order', ['folder' => $folder->id, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none px-3" title="{{ __('list.down') }}">
                                            ↓
                                        </a>
                                    @endif
                                </td>
                            @endif
                            <td class="w-10 px-0 ta-end">
                                <a href="{{ route('bo.folders.edit', ['folder' => $folder->id]) }}"
                                    class="btn btn-sm btn-primary mx-1"
                                    title="{{ __('list.edit_folder') }}">{{ __('list.edit') }}</a>
                                <form action="{{ route('bo.folders.destroy', $folder->id) }}" method="POST"
                                    class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" class="btn btn-sm btn-danger" value="{{ __('list.delete') }}"
                                        title="{{ __('list.delete_folder') }}"
                                        onclick="return confirm(`{{ __('list.are_you_sure') }}`)">
                                </form>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        @else
            <tr>
                <td class="w-25 border-0">{{ __('list.no_folders_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $folders->links() !!}
@endsection
