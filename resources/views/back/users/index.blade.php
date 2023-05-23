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
    @include('back.modules.search-bar')
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
                        <td class="text-center align-middle">
                            @if(Auth::user()->id === $user->id || Auth::user()->role === \App\Enums\Role::admin()->value)
                                {{ $user->email }}
                            @else
                                <span class="text-danger"
                                    title="{{ __('list.right') }}"
                                    data-bs="tooltip">
                                    <i class="fa-solid fa-ban"></i>
                                </span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            {{ ($user->role == App\Enums\Role::admin()->value) ? App\Enums\Role::admin()->label : App\Enums\Role::visitor()->label }}
                        </td>
                        @if(!$noOrder or $rst)
                        <td class="text-center align-middle">
                            @can('isAdmin')
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
                            @if(Auth::user()->id === $user->id || Auth::user()->role === \App\Enums\Role::admin()->value)
                                <form action="{{ route('bo.users.destroy', $user->id) }}"
                                    method="POST"
                                    class="btn-group confirmDeleteTS"
                                    novalidate>
                                    <a class="btn btn-sm btn-secondary"
                                        href="{{ route('bo.users.duplicate', ['user' => $user->id]) }}"
                                        data-bs="tooltip"
                                        data-bs-placement="top"
                                        title="{{ __('list.duplicate_user') }}">
                                        <i class="fa-solid fa-copy"></i>
                                    </a>
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
                <td class="border-0">{{ __('list.no_users_found') }}</td>
            </tr>
        @endif
    </table>
    {!! $users->links() !!}
@endsection
