@extends('layouts.backend')

@section('title', __('meta.all_users'))
@section('description', __('meta.all_users_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 border-top border-bottom">
        <h1 class="h2 m-0 fw-bold">{{ __('list.users') }} <small class="text-muted h4">{{ __('list.list') }}</small></h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="float-center text-danger">{{ $error }}</span>
            @endforeach
        @endif
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
    <form action="{{ request()->url() }}" enctype="multipart/form-data" id="search" class="d-flex flex-row input-group pt-3">
        <input class="form-control"
            type="text"
            placeholder="{{ __('search.search_user') }}"
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
            href="{{ route('bo.users.index') }}">
            <i class="fa-solid fa-delete-left"></i>
        </a>
    </form>
    <table class="table">
        @if (count($users) > 0)
            <thead>
                <tr>
                    <th scope="col" class="col-3">{{ __('list.name') }}</th>
                    <th scope="col" class="col-4">{{ __('list.email') }}</th>
                    <th scope="col" class="col-3">{{ __('list.role') }}</th>
                    @can('isAdmin')
                        @if (count($users) > 1)
                            <th scope="col" class="col-1 text-center">{{ __('list.order') }}</th>
                        @endif
                        <th scope="col" class="col-1"><!-- Empty --></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="list_item">
                        <td class="align-middle">{{ $user->name }}</td>
                        <td class="align-middle">{{ $user->email }}</td>
                        <td class="align-middle">
                            {{ ($user->role == App\Enums\Role::admin()->value) ? App\Enums\Role::admin()->label : App\Enums\Role::visitor()->label }}
                        </td>
                        @can('isAdmin')
                            @if ($loop->count > 1)
                                <td class="text-center align-middle">
                                    @if(!($loop->first and $users->onFirstPage()))
                                        <a href="{{ route('bo.users.change-order', ['user' => $user, 'direction' => 'up']) }}"
                                            class="btn-link text-decoration-none"
                                            data-bs="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('list.up') }}">
                                            <i class="fa-solid fa-arrow-up"></i>
                                        </a>
                                    @endif
                                    @if (!($loop->last and $users->currentPage() === $users->lastPage()))
                                        <a href="{{ route('bo.users.change-order', ['user' => $user, 'direction' => 'down']) }}"
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
