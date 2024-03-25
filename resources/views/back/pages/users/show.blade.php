@extends('back.layout', ['brParam' => $userModel])

@section('title', __('Édition d\'un :model', ['model' => __('models.user')]))
@section('description', __('Édition d\'un :model déjà existant', ['model' => __('models.user')]))
@section('breadcrumb', request()->route()->getName())

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        <div class="d-flex align-items-start flex-row">
            <a class="btn btn-primary text-decoration-none m-0" data-bs-tooltip="tooltip" data-bs-placement="top"
                href="{{ route('bo.users.index', ['sort_col' => 'created_at', 'sort_way' => 'desc']) }}"
                title="{{ __('crud.actions_model.list_all', ['model' => str(__('models.user'))->plural()]) }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            @include('breadcrumbs.breadcrumb-body', ['brParam' => $userModel])
        </div>
        <div class="btn-group">
            @can('resetPassword', $userModel)
                <form class="confirmActionTS" data-message="{{ __('crud.sweetalert.send_email') }}" method="POST"
                    action="{{ route('bo.password.email', ['email' => $userModel->email]) }}">
                    @csrf
                    <button class="btn btn-info rounded-end-0 w-fit" data-bs-tooltip="tooltip" type="submit"
                        title="{{ str(__('auth.reset_password_send'))->ucfirst() }}">
                        <i class="fa-solid fa-key"></i>
                    </button>
                </form>
            @endcan
            @canAny(['delete', 'duplicate', 'update'], $userModel)
                <form class="btn-group confirmActionTS" data-message="{{ __('crud.sweetalert.data_lost') }}"
                    action="{{ route('bo.users.destroy', $userModel->id) }}" method="POST" novalidate>
                    @can('duplicate', $userModel)
                        <a class="btn btn-secondary" data-bs-tooltip="tooltip" data-bs-placement="top"
                            href="{{ route('bo.users.duplicate', $userModel) }}"
                            title="{{ __('crud.actions_model.duplicate', ['model' => __('models.user')]) }}">
                            <i class="fa-solid fa-copy"></i>
                        </a>
                    @endcan
                    @can('update', $userModel)
                        <a class="btn btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top" href="{{ route('bo.users.edit', $userModel) }}"
                            title="{{ __('crud.actions_model.edit', ['model' => __('models.user')]) }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    @endcan
                    @can('delete', $userModel)
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                            title="{{ __('crud.actions_model.delete', ['model' => __('models.user')]) }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    @endcan
                </form>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive mb-3">
                <table class="table-hover m-0 table">
                    <tbody>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">{{ str(__('models.user'))->ucFirst() }}</td>
                            <td class="w-50 text-center align-middle">
                                {{ $userModel->first_name }}&nbsp;{{ $userModel->last_name }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">{{ str(__('validation.attributes.email'))->ucFirst() }}</td>
                            <td class="w-50 text-center align-middle">
                                {{ $userModel->email }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">{{ str(__('validation.attributes.role'))->ucFirst() }}</td>
                            <td class="w-50 text-center align-middle">
                                {{ str($userModel->role->label())->ucFirst() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">
                                {{ str(__('validation.custom.published_at'))->ucFirst() }}
                            </td>
                            <td class="w-50 text-center align-middle">
                                {{ $userModel->published
                                    ? str($userModel->created_at->isoFormat('LLLL'))->ucFirst()
                                    : __('bo_other_model_not_published', [
                                        'model' => str(__('models.user'))->ucFirst(),
                                    ]) }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">{{ str(__('validation.attributes.created_at'))->ucFirst() }}</td>
                            <td class="w-50 text-center align-middle">
                                {{ str($userModel->created_at->isoFormat('LLLL'))->ucFirst() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">{{ str(__('validation.attributes.updated_at'))->ucFirst() }}</td>
                            <td class="w-50 text-center align-middle">
                                {{ str($userModel->updated_at->isoFormat('LLLL'))->ucFirst() }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
