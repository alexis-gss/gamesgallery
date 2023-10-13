@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => trans_choice('models.activity_log', 2)]))
@section('description', __('crud.meta.all_models_list', ['model' => trans_choice('models.activity_log', 2)]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
</div>
@include('back.modules.search-bar')
<div class="table-responsive mb-3">
    <table class="table table-hover table-fix-action m-0">
        @if (count($activitylogModels) > 0)
        <thead>
            @include('back.modules.table-col-sorter', [
                'cols' => [
                    'event'      => Str::of(__('validation.custom.event'))->ucfirst(),
                    'user'       => Str::of(__('models.user'))->ucfirst(),
                    'model'      => Str::of(__('validation.custom.model'))->ucfirst(),
                    'created_at' => Str::of(__('validation.attributes.created_at'))->ucfirst(),
                ],
            ])
        </thead>
        <tbody>
            @foreach ($activitylogModels as $activitylogModel)
            <tr class="border-bottom">
                <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-{{ $activitylogModel->event->bootstrapClass() }}-emphasis text-center align-middle">
                    {{ Str::of($activitylogModel->event->label())->ucFirst() }}
                </td>
                <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                    @if (isset($activitylogModel->user))
                    <a class="btn btn-sm btn-primary text-decoration-none"
                        href="{{ route('bo.users.edit', $activitylogModel->user) }}"
                        title="{{ __('crud.actions_model.show', ['model' => __('models.user')]) }}"
                        data-bs="tooltip">
                        {{ $activitylogModel->user->last_name }}&nbsp;{{ $activitylogModel->user->first_name }}
                    </a>
                    @elseif($activitylogModel->is_console)
                        {{ __('Utilisateur dans la console') }}
                    @elseif($activitylogModel->is_anonymous)
                    {{ __('texts.bo.other.user_anonym') }}
                    @else
                    {{ __('texts.bo.other.user_deleted') }}
                    @endif
                </td>
                @php
                    $targetModel = $activitylogModel->model_class::where((new $activitylogModel->model_class())->getRouteKeyName(), $activitylogModel->model_id)->first();
                    $editRouteName = 'bo.' . optional($targetModel)->getTable() . '.edit';
                @endphp
                <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                    @if (!empty($targetModel) and Route::has($editRouteName))
                    <a class="btn btn-sm btn-primary text-decoration-none @if(!isset($targetModel)) disabled @endif"
                        href="{{ route('bo.' . $targetModel->getTable() . '.edit', $targetModel) }}"
                        title="{{ __('crud.actions_model.show', ['model' => __('models.' . Str::of($targetModel->getTable())->singular())]) }}"
                        data-bs="tooltip">
                        @endif
                        {{ $activitylogModel->model_class }}
                    @if (!empty($targetModel) and Route::has($editRouteName))
                    </a>
                    @endif
                </td>
                <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                    <span class="badge bg-secondary">
                        {{ $activitylogModel->created_at->isoFormat('LLLL') }}
                    </span>
                </td>
                <td class="text-end align-middle">
                    @can('isConceptor')
                    <a class="btn btn-sm btn-warning"
                        href="{{ route('bo.activity_logs.show', ['activity_log' => $activitylogModel]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
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
