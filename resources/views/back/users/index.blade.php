@extends('layouts.backend')

@section('title', __('meta.all_users'))
@section('description', __('meta.all_users_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
        @include('breadcrumbs.breadcrumb-body')
        @can('isAdmin')
            <a href="{{ route('bo.users.create') }}"
                class="btn btn-primary float-right"
                data-bs="tooltip"
                data-bs-placement="top"
                title="{{ __('list.create_new_user') }}">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    <form action="{{ request()->url() }}" enctype="multipart/form-data" id="search"
        class="d-flex flex-row input-group pt-3">
        <label class="input-group-text" for="searchField">{{ $searchFields }}</label>
        <input class="form-control"
            type="text"
            placeholder="{{ __('search.search_user') }}"
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
            href="{{ route('bo.users.index') }}">
            <i class="fa-solid fa-delete-left"></i>
        </a>
    </form>
    <table class="table">
        @if (count($users) > 0)
            <thead>
                @php
                $rst = !is_null(request()->rst);
                $routeName = request()->route()->getName();
                $noOrder = Session::get("$routeName.sort_col") !== 'order' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $noOrder = Session::get("$routeName.sort_col") !== '' and (Session::has("$routeName.sort_col") or Session::has("$routeName.sort_way"));
                $cols = ['name' => __('list.name'), 'email' => __('list.email'), 'role' => __('list.role'), 'order' => __('list.order')];
                @endphp
                @include('back.modules.table-col-sorter', [
                    'cols' => $cols,
                    'mobileHide' => [],
                ])
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="list_item border-bottom">
                        <td class="text-center align-middle">{{ $user->name }}</td>
                        <td class="text-center align-middle">{{ $user->email }}</td>
                        <td class="text-center align-middle">
                            {{ ($user->role == App\Enums\Role::admin()->value) ? App\Enums\Role::admin()->label : App\Enums\Role::visitor()->label }}
                        </td>
                        @can('isAdmin')
                            @if(!$noOrder or $rst)
                            <td class="align-middle">
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('bo.users.change-order', ['user' => $user, 'direction' => 'up']) }}"
                                        class="@if($loop->first and $users->onFirstPage()) invisible @endif">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-dark @if(($loop->first and $users->onFirstPage())) disabled @endif"
                                            title="{{ __('list.up') }}"
                                            data-bs="tooltip">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('bo.users.change-order', ['user' => $user, 'direction' => 'down']) }}"
                                        class="@if($loop->last and $users->currentPage() === $users->lastPage()) invisible @endif">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-dark ms-1 @if($loop->last and $users->currentPage() === $users->lastPage()) disabled @endif"
                                            title="{{ __('list.down') }}"
                                            data-bs="tooltip">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            @endif
                            <td class="text-end align-middle">
                                <form action="{{ route('bo.users.destroy', $user->id) }}"
                                    method="POST"
                                    class="btn-group confirmDeleteTS"
                                    role="group"
                                    novalidate>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('bo.users.edit', ['user' => $user->id]) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.edit_user') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        type="submit"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.delete_user') }}">
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
                <td class="border-0">{{ __('list.no_users_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $users->links() !!}
@endsection
