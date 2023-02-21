@extends('layouts.backend')

@section('title', __('meta.all_folders'))
@section('description', __('meta.all_folders_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 border-top border-bottom">
        <h1 class="h2 m-0 fw-bold">{{ __('list.folders') }} <small class="text-muted h4">{{ __('list.list') }}</small></h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="float-center text-danger">{{ $error }}</span>
            @endforeach
        @endif
        @can('isAdmin')
            <a href="{{ route('bo.folders.create') }}"
                class="btn btn-primary float-right"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('list.create_new_folder') }}">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    <form action="{{ request()->url() }}" enctype="multipart/form-data" id="search"
        class="d-flex flex-row input-group pt-3">
        <input class="form-control"
            type="text"
            placeholder="{{ __('search.search_folder') }}"
            id="search"
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
            href="{{ route('bo.folders.index') }}">
            <i class="fa-solid fa-delete-left"></i>
        </a>
    </form>
    <table class="table">
        @if (count($folders) > 0)
            <thead>
                <tr>
                    <th scope="col" class="col-5">{{ __('list.name') }}</th>
                    <th scope="col" class="col-5">{{ __('list.games_associated') }}</th>
                    @can('isAdmin')
                        <th scope="col" class="d-none d-lg-table-cell col-1 text-center">{{ __('list.publishment') }}</th>
                        @if (count($folders) > 1)
                            <th scope="col" class="col-1 text-center">{{ __('list.order') }}</th>
                        @endif
                        <th scope="col" class="col-1"><!-- Empty --></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($folders as $folder)
                    <tr class="list-item">
                        <td class="align-middle">{{ $folder->name }}</td>
                        <td>
                            <a href="{{ route('bo.games.index', ['filter' => $folder->id]) }}"
                                data-bs="tooltip"
                                data-bs-placement="top" title="{{ __('list.show_games') }}"
                                class="text-decoration-none">
                                {{ count($folder->games) }}
                            </a>
                        </td>
                        @can('isAdmin')
                            <td class="d-none d-lg-table-cell text-center align-middle">
                                <form action="{{ route('bo.folders.change-published', $folder->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm"
                                        title="{{ __($folder->status ? __('list.unpublish') : __('list.publish')) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top">
                                        @if($folder->status)
                                            <i class="fa-solid fa-circle-check text-primary"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            @if ($loop->count > 1)
                                <td class="text-center align-middle">
                                    @if(!($loop->first and $folders->onFirstPage()))
                                        <a href="{{ route('bo.folders.change-order', ['folder' => $folder, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none"
                                            data-bs="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('list.up') }}">
                                            <i class="fa-solid fa-arrow-up"></i>
                                        </a>
                                    @endif
                                    @if (!($loop->last and $folders->currentPage() === $folders->lastPage()))
                                        <a href="{{ route('bo.folders.change-order', ['folder' => $folder, 'direction' => 'down']) }}"
                                            class="btn-link text-decoration-none"
                                            data-bs="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('list.down') }}">
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </a>
                                    @endif
                                </td>
                            @endif
                            <td class="text-end align-middle">
                                <form action="{{ route('bo.folders.destroy', $folder->id) }}"
                                    method="POST"
                                    class="btn-group confirmDeleteTS"
                                    novalidate>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('bo.folders.edit', ['folder' => $folder->id]) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.edit_folder') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.delete_folder') }}">
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
                <td class="border-0">{{ __('list.no_folders_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $folders->links() !!}
@endsection
