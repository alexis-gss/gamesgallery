@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => trans_choice('models.activity_log', \INF)]))
@section('description', __('crud.meta.all_models_list', ['model' => trans_choice('models.activity_log', \INF)]))

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        @include('breadcrumbs.breadcrumb-body')
    </div>
    @include('back.modules.search-bar')
    <div class="table-responsive mb-3">
        <table class="table-hover table-fix-action m-0 table">
            @if (count($activitylogModels) > 0)
                <thead>
                    @include('back.modules.table-col-sorter', [
                        'cols' => [
                            'event' => str(__('validation.custom.event'))->ucfirst(),
                            'user' => str(__('models.user'))->ucfirst(),
                            'model' => str(__('validation.custom.model'))->ucfirst(),
                            'created_at' => str(__('validation.attributes.created_at'))->ucfirst(),
                        ],
                    ])
                </thead>
                <tbody>
                    @foreach ($activitylogModels as $activitylogModel)
                        <tr class="border-bottom">
                            <td
                                class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-{{ $activitylogModel->event->bootstrapClass() }}-emphasis text-center align-middle">
                                {{ str($activitylogModel->event->label())->ucFirst() }}
                            </td>
                            <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                                @if (isset($activitylogModel->user))
                                    <a class="btn btn-sm btn-primary text-decoration-none" data-bs-tooltip="tooltip"
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
                            @php
                                $targetModel = $activitylogModel->model_class
                                    ::where((new $activitylogModel->model_class())->getRouteKeyName(), $activitylogModel->model_id)
                                    ->first();
                                $editRouteName = 'bo.' . optional($targetModel)->getTable() . '.edit';
                            @endphp
                            <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                                @if (!empty($targetModel) and Route::has($editRouteName))
                                    <a data-bs-tooltip="tooltip" href="{{ route('bo.' . $targetModel->getTable() . '.edit', $targetModel) }}"
                                        title="{{ __('crud.actions_model.show', ['model' => __('models.' . str($targetModel->getTable())->singular())]) }}"
                                        @class([
                                            'btn btn-sm btn-primary text-decoration-none',
                                            'disabled' => !isset($targetModel),
                                        ])>
                                @endif
                                {{ $activitylogModel->model_class }}
                                @if (!empty($targetModel) and Route::has($editRouteName))
                                    </a>
                                @endif
                            </td>
                            <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                                <span class="badge rounded-pill bg-secondary">
                                    {{ $activitylogModel->created_at->isoFormat('LLLL') }}
                                </span>
                            </td>
                            <td class="text-end align-middle">
                                @can('isConceptor')
                                    <a class="btn btn-sm btn-warning" data-bs-tooltip="tooltip" data-bs-placement="top"
                                        href="{{ route('bo.activity_logs.show', ['activity_log' => $activitylogModel]) }}"
                                        title="{{ __('crud.actions_model.show', ['model' => trans_choice('models.activity_log', 1)]) }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tr>
                    <td class="border-0">{{ __('crud.other.no_model_found', ['model' => trans_choice('models.activity_log', 1)]) }}</td>
                </tr>
            @endif
        </table>
    </div>
    {!! $activitylogModels->links() !!}
@endsection
