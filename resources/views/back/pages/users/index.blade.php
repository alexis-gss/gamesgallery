@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => Str::of(__('models.user'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => Str::of(__('models.user'))->plural()]))

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        @include('breadcrumbs.breadcrumb-body')
        @can('create', \App\Models\User::class)
            <a class="btn btn-primary float-right" data-bs-tooltip="tooltip" data-bs-placement="top" href="{{ route('bo.users.create') }}"
                title="{{ __('crud.actions_model.create', ['model' => __('models.user')]) }}">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    @include('back.modules.search-bar')
    <div class="table-responsive mb-3">
        <table class="table-hover table-fix-action m-0 table">
            @if (count($userModels) > 0)
                <thead>
                    @include('back.modules.table-col-sorter', [
                        'cols' => [
                            'first_name' => Str::of(__('validation.attributes.first_name'))->ucfirst(),
                            'last_name' => Str::of(__('validation.attributes.last_name'))->ucfirst(),
                            'email' => Str::of(__('validation.attributes.email'))->ucfirst(),
                            'role' => Str::of(__('validation.attributes.role'))->ucfirst(),
                            'published' => Str::of(__('validation.custom.publishment'))->ucfirst(),
                            'updated_at' => Str::of(__('validation.attributes.updated_at'))->ucfirst(),
                            'order' => Str::of(__('validation.custom.order'))->ucfirst(),
                        ],
                    ])
                </thead>
                <tbody>
                    @foreach ($userModels as $userModel)
                        <tr class="border-bottom">
                            <td class="text-center align-middle">{{ $userModel->first_name }}</td>
                            <td class="text-center align-middle">{{ $userModel->last_name }}</td>
                            <td class="text-center align-middle">
                                @if (auth('backend')->user()->getRouteKey() === $userModel->getRouteKey() || Gate::check('isConceptor'))
                                    {{ $userModel->email }}
                                @else
                                    @include('back.modules.user-right')
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                {{ $userModel->role->label() }}
                            </td>
                            @include('back.modules.change-published-status', [
                                'routeName' => 'users',
                                'model' => $userModel,
                            ])
                            <td class="text-center align-middle">
                                <span class="badge bg-secondary">{{ $userModel->updated_at->isoFormat('LLLL') }}</span>
                            </td>
                            @php $routeName = request()->route()->getName(); @endphp
                            @if (empty(request()->search) && Session::get("$routeName.sort_col") === 'order')
                                @include('back.modules.change-model-order', [
                                    'routeName' => 'users',
                                    'models' => $userModels,
                                    'model' => $userModel,
                                ])
                            @endif
                            <td class="text-end align-middle">
                                @canAny(['delete', 'duplicate', 'update'], $userModel)
                                    <form class="btn-group confirmDeleteTS" action="{{ route('bo.users.destroy', $userModel->id) }}" method="POST"
                                        novalidate>
                                        @can('duplicate', $userModel)
                                            <a class="btn btn-sm btn-secondary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.users.duplicate', $userModel) }}"
                                                title="{{ __('crud.actions_model.duplicate', ['model' => __('models.user')]) }}">
                                                <i class="fa-solid fa-copy"></i>
                                            </a>
                                        @endcan
                                        @can('update', $userModel)
                                            <a class="btn btn-sm btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.users.edit', $userModel) }}"
                                                title="{{ __('crud.actions_model.edit', ['model' => __('models.user')]) }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $userModel)
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                                                title="{{ __('crud.actions_model.delete', ['model' => __('models.user')]) }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
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
                    <td class="border-0">{{ __('crud.other.no_model_found', ['model' => __('models.user')]) }}</td>
                </tr>
            @endif
        </table>
    </div>
    {{ $userModels->links() }}
@endsection
