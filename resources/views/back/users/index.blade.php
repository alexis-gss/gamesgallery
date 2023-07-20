@extends('layouts.backend')

@section('title', __('meta.all_users'))
@section('description', __('meta.all_users_desc'))

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
<table class="table table-hover">
    @if (count($users) > 0)
    <thead>
        @php
        $cols = [
            'name' => __('list.name'),
            'email' => __('list.email'),
            'role' => __('list.role'),
            'order' => __('list.order')
        ];
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
                @if(Auth::user()->id === $user->id || Auth::user()->role === \App\Enums\Users\RoleEnum::admin()->value)
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
                {{ ($user->role == App\Enums\Users\RoleEnum::admin()->value) ? App\Enums\Users\RoleEnum::admin()->label : App\Enums\Users\RoleEnum::visitor()->label }}
            </td>
            @php $routeName = request()->route()->getName(); @endphp
            @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
            @include('back.modules.change-model-order', [
                'routeName' => 'users',
                'models' => $users,
                'model' => $user
            ])
            @endif
            <td class="text-end align-middle">
                @if(Auth::user()->id === $user->id || Auth::user()->role === \App\Enums\Users\RoleEnum::admin()->value)
                <form action="{{ route('bo.users.destroy', $user->id) }}"
                    method="POST"
                    class="btn-group confirmDeleteTS"
                    novalidate>
                    @can('isAdmin')
                    <a class="btn btn-sm btn-secondary"
                        href="{{ route('bo.users.duplicate', ['user' => $user->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('list.duplicate_user') }}">
                        <i class="fa-solid fa-copy"></i>
                    </a>
                    @endcan
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
