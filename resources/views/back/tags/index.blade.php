@extends('layouts.backend')

@section('title', __('meta.all_tags'))
@section('description', __('meta.all_tags_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 border-top border-bottom">
        <h1 class="h2 m-0 fw-bold">{{ __('list.tags') }} <small class="text-muted h4">{{ __('list.list') }}</small></h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="float-center text-danger">{{ $error }}</span>
            @endforeach
        @endif
        @can('isAdmin')
            <a href="{{ route('bo.tags.create') }}"
                class="btn btn-primary float-right"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('list.create_new_tag') }}">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    <form action="{{ request()->url() }}" enctype="multipart/form-data" id="search"
        class="d-flex flex-row input-group pt-3 pb-2">
        <label class="input-group-text" for="searchField">{{ $searchFields }}</label>
        <input class="form-control"
            type="text"
            placeholder="{{ __('search.search_tag') }}"
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
            href="{{ route('bo.tags.index') }}">
            <i class="fa-solid fa-delete-left"></i>
        </a>
    </form>
    <table class="table">
        @if (count($tags) > 0)
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
                @foreach ($tags as $tag)
                    <tr class="list-item border-bottom">
                        <td class="text-center align-middle">{{ $tag->name }}</td>
                        @can('isAdmin')
                            <td class="d-none d-lg-table-cell text-center align-middle">
                                <form action="{{ route('bo.tags.change-published', $tag->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm @if($tag->status) btn-primary @else btn-danger @endif"
                                        title="{{ __($tag->status ? __('list.unpublish') : __('list.publish')) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top">
                                        @if($tag->status)
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
                                    <a href="{{ route('bo.tags.change-order', ['tag' => $tag, 'direction' => 'up']) }}"
                                        class="@if($loop->first and $tags->onFirstPage()) invisible @endif">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-dark @if(($loop->first and $tags->onFirstPage())) disabled @endif"
                                            title="{{ __('list.up') }}"
                                            data-bs="tooltip">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('bo.tags.change-order', ['tag' => $tag, 'direction' => 'down']) }}"
                                        class="@if($loop->last and $tags->currentPage() === $tags->lastPage()) invisible @endif">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-dark ms-1 @if($loop->last and $tags->currentPage() === $tags->lastPage()) disabled @endif"
                                            title="{{ __('list.down') }}"
                                            data-bs="tooltip">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            @endif
                            <td class="text-end align-middle">
                                <form action="{{ route('bo.tags.destroy', $tag->id) }}"
                                    method="POST"
                                    class="btn-group confirmDeleteTS"
                                    novalidate>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('bo.tags.edit', ['tag' => $tag->id]) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.edit_tag') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.delete_tag') }}">
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
                <td class="border-0">{{ __('list.no_tags_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $tags->links() !!}
@endsection
