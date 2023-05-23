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
    @include('back.modules.search-bar')
    <table class="table">
        @if (count($folders) > 0)
            <thead>
                @php
                $rst = !is_null(request()->rst);
                $routeName = request()->route()->getName();
                $noOrder = Session::get("$routeName.sort_col") !== 'order' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $noOrder = Session::get("$routeName.sort_col") !== '' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $cols = ['name' => __('list.name'), 'color' => __('list.color'), 'status' => __('list.publishment'), 'order' => __('list.order')];
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
                        <td class="text-center align-middle">
                            @php
                            $data = [
                                'id' => "colorPicker" . $folder->id,
                                'name' => 'color',
                                'value' => old('color', $folder->color ?? ''),
                                'title' => __('Choisissez la couleur du paramètre'),
                                'label' => __('Couleur du paramètre'),
                                'rgbaMode' => false,
                                'nullable' => false,
                                'ariaDescribedby' => 'colorPickerHelp',
                                'simple' => true,
                                'disabled' => true
                            ];
                            @endphp
                            <div class="color-picker" data-json='@json($data)'></div>
                        </td>
                        <td class="d-none d-lg-table-cell text-center align-middle">
                            @can('isAdmin')
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
                                <form action="{{ route('bo.folders.destroy', $folder->id) }}"
                                    method="POST"
                                    class="btn-group confirmDeleteTS"
                                    novalidate>
                                    <a class="btn btn-sm btn-secondary"
                                        href="{{ route('bo.folders.duplicate', ['folder' => $folder->id]) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.duplicate_folder') }}">
                                        <i class="fa-solid fa-copy"></i>
                                    </a>
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
                <td class="border-0">{{ __('list.no_folders_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $folders->links() !!}
@endsection
