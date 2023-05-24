@extends('layouts.backend')

@section('title', __('meta.all_tags'))
@section('description', __('meta.all_tags_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
        @include('breadcrumbs.breadcrumb-body')
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
    @include('back.modules.search-bar')
    <table class="table">
        @if (count($tags) > 0)
            <thead>
                @php
                $rst = !is_null(request()->rst);
                $routeName = request()->route()->getName();
                $noOrder = Session::get("$routeName.sort_col") !== 'order' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $noOrder = Session::get("$routeName.sort_col") !== '' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $cols = ['name' => __('list.name'), 'published' => __('list.publishment'), 'order' => __('list.order')];
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
                        <td class="d-none d-lg-table-cell text-center align-middle">
                            @can('isAdmin')
                                <form action="{{ route('bo.tags.change-published', $tag->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm @if($tag->published) btn-primary @else btn-danger @endif"
                                        title="{{ __($tag->published ? __('list.unpublish') : __('list.publish')) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top">
                                        @if($tag->published)
                                            <i class="fa-solid fa-circle-check"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        @endif
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
                        @if(!$noOrder or $rst)
                        <td class="text-center align-middle">
                            @can('isAdmin')
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
                            @else
                                <span class="text-danger"
                                    title="{{ __('list.right') }}"
                                    data-bs="tooltip">
                                    <i class="fa-solid fa-ban"></i>
                                </span>
                            @endcan
                        </td>
                        @endif
                        <td class="text-end align-middle">
                            @can('isAdmin')
                                <form action="{{ route('bo.tags.destroy', $tag->id) }}"
                                    method="POST"
                                    class="btn-group confirmDeleteTS"
                                    novalidate>
                                    <a class="btn btn-sm btn-secondary"
                                        href="{{ route('bo.tags.duplicate', ['tag' => $tag->id]) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.duplicate_tag') }}">
                                        <i class="fa-solid fa-copy"></i>
                                    </a>
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
                <td class="border-0">{{ __('list.no_tags_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $tags->links() !!}
@endsection
