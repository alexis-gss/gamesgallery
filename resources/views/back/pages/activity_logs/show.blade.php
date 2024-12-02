@extends('back.layout', ['brParam' => $activitylogModel])

@section('title', __('crud.meta.view_model', ['model' => __('models.activity_logs')]))
@section('description', __('crud.meta.view_model_desc', ['model' => __('models.activity_logs')]))
@section('breadcrumb', request()->route()->getName())

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center flex-wrap pb-3">
        <div class="d-flex align-items-start flex-row">
            <a class="btn btn-primary text-decoration-none m-0" data-bs-tooltip="tooltip" data-bs-placement="top"
                href="{{ route('bo.activity_logs.index', ['sort_col' => 'created_at', 'sort_way' => 'desc']) }}"
                title="{{ __('crud.actions_model.list_all', ['model' => trans_choice(__('models.activity_log'), \INF)]) }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <x-breadcrumbs.breadcrumb-body :brParam="$activitylogModel" />
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="bg-body-tertiary border rounded-3 p-3 mb-3">
                <legend class="fw-bold fst-italic">
                    <i class="fa-solid fa-gears"></i>
                    {{ __('bo_title_general_informations') }}
                </legend>
                <div class="table-responsive">
                    <table class="table-hover m-0 table">
                        <tbody>
                            <tr class="border-bottom">
                                <td class="w-50 rounded-top rounded-end-0 fw-bold text-center align-middle">
                                    {{ str(__('models.user'))->ucFirst() }}
                                </td>
                                <td class="w-50 rounded-top rounded-start-0 text-center align-middle">
                                    @if (isset($activitylogModel->user))
                                        <a class="btn btn-sm btn-primary" data-bs-tooltip="tooltip"
                                            href="{{ route('bo.users.edit', $activitylogModel->user) }}"
                                            title="{{ __('crud.actions_model.show', ['model' => __('models.user')]) }}">
                                            {{ $activitylogModel->user->last_name }}&nbsp;{{ $activitylogModel->user->first_name }}
                                        </a>
                                    @elseif($activitylogModel->is_console)
                                        {{ __('bo_other_user_console') }}
                                    @elseif($activitylogModel->is_anonymous)
                                        {{ __('bo_other_user_anonym') }}
                                    @else
                                        {{ __('bo_other_user_deleted') }}
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.custom.event'))->ucFirst() }}</td>
                                <td class="w-50 text-center align-middle">
                                    <span
                                        class="text-{{ $activitylogModel->event->bootstrapClass() }}-emphasis bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle border-{{ $activitylogModel->event->bootstrapClass() }}-subtle rounded-3 border p-1">
                                        {{ str($activitylogModel->event->label())->ucFirst() }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.custom.model'))->ucFirst() }}</td>
                                <td class="w-50 text-center align-middle">
                                    @if (isset($targetModel))
                                        <a class="btn btn-sm btn-primary" data-bs-tooltip="tooltip"
                                            href="{{ route('bo.' . $targetModel->getTable() . '.edit', $targetModel) }}"
                                            title="{{ __('crud.actions_model.show', ['model' => trans_choice('models.' . str($targetModel->getTable())->singular(), 1)]) }}">
                                    @endif
                                    {{ $activitylogModel->model_class }}
                                    @if (isset($targetModel))
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="w-50 fw-bold text-center align-middle border-0">
                                    {{ str(__('validation.attributes.created_at'))->ucFirst() }}</td>
                                <td class="w-50 text-center align-middle border-0">
                                    <span class="badge rounded-pill text-bg-secondary">
                                        {{ $activitylogModel->created_at->isoFormat('LLLL') }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if (isset($activitylogModel->data) && count($activitylogModel->data))
            <div class="col-12 mb-3">
                <div class="bg-body-tertiary border rounded-3 p-3">
                    <legend class="fw-bold fst-italic">
                        <i class="fa-solid fa-file-pen"></i>
                        {{ __('bo_title_changes_made') }}
                    </legend>
                    <div class="table-responsive">
                        <table class="table-hover m-0 table">
                            <thead>
                                <tr
                                    class="table-col-sorter border-start-0 border-end-0 border-top-0 border-secondary border border-2">
                                    <td class="w-50 fw-bold text-center align-middle">
                                        {{ __('bo_other_column') }}
                                    </td>
                                    <td class="fw-bold text-center align-middle">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </td>
                                    <td class="w-50 fw-bold text-center align-middle border-0">
                                        {{ __('bo_other_type') }}
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activitylogModel->data as $key => $dataType)
                                    <tr @class(['border-0' => $loop->last])>
                                        <td @class([
                                            'fw-bold text-center align-middle',
                                            'border-0' => $loop->last,
                                        ])>
                                            {{ $key }}
                                        </td>
                                        <td @class([
                                            'fw-bold text-center align-middle',
                                            'border-0' => $loop->last,
                                        ])>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </td>
                                        <td @class(['w-25 text-center align-middle', 'border-0' => $loop->last])>
                                            {{ $dataType }}
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </fieldset>
            </div>
        @endif
    </div>
@endsection
