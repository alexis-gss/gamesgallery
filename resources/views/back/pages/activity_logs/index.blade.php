@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => trans_choice('models.activities', 2)]))
@section('description', __('crud.meta.all_models_list', ['model' => trans_choice('models.activities', 2)]))

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
                    'event'      => __('validation.attributes.event'),
                    'user'       => Str::singular(__('models.users')),
                    'model'      => __('validation.attributes.model'),
                    'created_at' => __('validation.attributes.created_at'),
                ],
            ])
        </thead>
        <tbody>
            @foreach ($activitylogModels as $activitylogModel)
            <tr class="border-bottom">
                <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-{{ $activitylogModel->event->bootstrapClass() }}-emphasis text-center align-middle">
                    {{ $activitylogModel->event->label() }}
                </td>
                <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                    @if (isset($activitylogModel->user))
                    <a class="btn btn-sm btn-primary text-decoration-none"
                        href="{{ route('bo.users.edit', $activitylogModel->user) }}"
                        title="{{ __('crud.actions_model.show', ['model' => Str::singular(__('models.users'))]) }}"
                        data-bs="tooltip">
                        {{ $activitylogModel->user->name }}
                    </a>
                    @elseif($activitylogModel->is_anonymous)
                    {{ __('texts.bo.other.user_anonym') }}
                    @else
                    {{ __('texts.bo.other.user_deleted') }}
                    @endif
                </td>
                @php $targetModel = $activitylogModel->model::where('id', $activitylogModel->model_id)->first(); @endphp
                <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                    <a class="btn btn-sm btn-primary text-decoration-none @if(!isset($targetModel)) disabled @endif"
                        @if(isset($targetModel))
                        href="{{ route('bo.' . $targetModel->getTable() . '.edit', $targetModel->id) }}"
                        title="{{ __('crud.actions_model.show', ['model' => Str::singular(__('models.' . $targetModel->getTable()))]) }}"
                        data-bs="tooltip"
                        @endif>
                    {{ $activitylogModel->model }}
                    </a>
                </td>
                <td class="bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle text-center align-middle">
                    <span class="badge bg-secondary">
                        {{ $activitylogModel->created_at }}
                    </span>
                </td>
                <td class="text-end align-middle">
                    @can('isAdmin')
                    <a class="btn btn-sm btn-warning"
                        href="{{ route('bo.activity_logs.show', ['activity_log' => $activitylogModel->id]) }}"
                        data-bs="tooltip"
                        data-bs-placement="top"
                        title="{{ __('crud.actions_model.show', ['model' => trans_choice('models.activities', 1)]) }}">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
        @else
        <tr>
            <td class="border-0">{{ __('crud.other.no_model_found', ['model' => trans_choice('models.activities', 1)]) }}</td>
        </tr>
        @endif
    </table>
</div>
{!! $activitylogModels->links() !!}
@endsection
