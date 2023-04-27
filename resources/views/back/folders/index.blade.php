@extends('layouts.backend')

@section('title', __('meta.all_folders'))
@section('description', __('meta.all_folders_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
        @include('breadcrumbs.breadcrumb-body')
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
        class="d-flex flex-row input-group pt-3 pb-2">
        <label class="input-group-text" for="searchField">{{ $searchFields }}</label>
        <input class="form-control"
            type="text"
            placeholder="{{ __('search.search_folder') }}"
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
            href="{{ route('bo.folders.index') }}">
            <i class="fa-solid fa-delete-left"></i>
        </a>
    </form>
    <table class="table">
        @if (count($folders) > 0)
            <thead>
                @php
                $rst = !is_null(request()->rst);
                $routeName = request()->route()->getName();
                $noOrder = Session::get("$routeName.sort_col") !== 'order' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $noOrder = Session::get("$routeName.sort_col") !== '' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $cols = ['name' => __('list.name'), 'status' => __('list.publishment'), 'order' => __('list.order')];
                @endphp
                @include('back.modules.table-col-sorter', [
                    'cols' => $cols,
                    'mobileHide' => [],
                ])
            </thead>
            <tbody>
                @foreach ($folders as $folder)
                    <tr class="list-item border-bottom">
                        <td class="text-center align-middle">{{ $folder->name }}</td>
                        @can('isAdmin')
                            <td class="d-none d-lg-table-cell text-center align-middle">
                                <form action="{{ route('bo.folders.change-published', $folder->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm @if($folder->status) btn-primary @else btn-danger @endif"
                                        title="{{ __($folder->status ? __('list.unpublish') : __('list.publish')) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top">
                                        @if($folder->status)
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
                                    <a href="{{ route('bo.folders.change-order', ['folder' => $folder, 'direction' => 'up']) }}"
                                        class="@if($loop->first and $folders->onFirstPage()) invisible @endif">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-dark @if(($loop->first and $folders->onFirstPage())) disabled @endif"
                                            title="{{ __('list.up') }}"
                                            data-bs="tooltip">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('bo.folders.change-order', ['folder' => $folder, 'direction' => 'down']) }}"
                                        class="@if($loop->last and $folders->currentPage() === $folders->lastPage()) invisible @endif">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-dark ms-1 @if($loop->last and $folders->currentPage() === $folders->lastPage()) disabled @endif"
                                            title="{{ __('list.down') }}"
                                            data-bs="tooltip">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    </a>
                                </div>
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
