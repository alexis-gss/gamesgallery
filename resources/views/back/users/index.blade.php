@extends('layouts.backend')

@section('title', __('crud.meta.all_models', ['model' => __('models.users')]))
@section('description', __('crud.meta.all_models_list', ['model' => __('models.users')]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
    @can('isAdmin')
    <a href="{{ route('bo.users.create') }}"
        class="btn btn-primary float-right"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('crud.actions_model.create', ['model' => Str::singular(__('models.users'))]) }}">
        <i class="fa-solid fa-plus"></i>
    </a>
    @endcan
</div>
@include('back.modules.search-bar')
<table class="table table-hover">
    @if (count($users) > 0)
    <thead>
        @include('back.modules.table-col-sorter', [
            'cols' => [
                'name'  => __('validation.attributes.name'),
                'email' => __('validation.attributes.email'),
                'role'  => __('validation.attributes.role'),
                'order' => __('validation.attributes.order')
            ],
        ])
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr class="list_item border-bottom">
            <td class="text-center align-middle">{{ $user->name }}</td>
            <td class="text-center align-middle">
                @if(Auth::user()->id === $user->id || Gate::check('isAdmin'))
                {{ $user->email }}
                @else
                @include('back.modules.user-right')
                @endif
            </td>
            <td class="text-center align-middle">
                {{ ($user->role === \App\Enums\Users\RoleEnum::admin) ? \App\Enums\Users\RoleEnum::admin->label() : \App\Enums\Users\RoleEnum::visitor->label() }}
            </td>
            @php $routeName = request()->route()->getName(); @endphp
            @if(empty(request()->search) && Session::get("$routeName.sort_col") === "order")
            @include('back.modules.change-model-order', [
                'routeName' => 'users',
                'models'    => $users,
                'model'     => $user
            ])
            @endif
            <td class="text-end align-middle">
                @if(Auth::user()->id === $user->id || Gate::check('isAdmin'))
                <form action="{{ route('bo.users.destroy', $user->id) }}"
                    method="POST"
                    class="btn-group confirmDeleteTS"
                    novalidate>
                    @can('isAdmin')
                    <a class="btn btn-sm btn-secondary"
                        href="{{ route('bo.users.duplicate', ['user' => $user->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('crud.actions_model.duplicate', ['model' => Str::singular(__('models.users'))]) }}">
                        <i class="fa-solid fa-copy"></i>
                    </a>
                    @endcan
                    <a class="btn btn-sm btn-primary"
                        href="{{ route('bo.users.edit', ['user' => $user->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('crud.actions_model.edit', ['model' => Str::singular(__('models.users'))]) }}">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                        type="submit"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('crud.actions_model.delete', ['model' => Str::singular(__('models.users'))]) }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
                @else
                @include('back.modules.user-right')
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
    @else
    <tr>
        <td class="border-0">{{ __('crud.other.no_model_found', ['model' => Str::singular(__('models.users'))]) }}</td>
    </tr>
    @endif
</table>
{!! $users->links() !!}
@endsection
