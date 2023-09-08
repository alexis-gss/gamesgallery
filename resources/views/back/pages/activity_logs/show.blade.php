@extends('layouts.backend', ['brParam' => $activitylogModel])

@section('title', __('Édition d\'un :model', ['model' => Str::singular(__('models.classes.activity_logs'))]))
@section('description', __('Édition d\'un :model déjà existant', ['model' => Str::singular(__('models.classes.activity_logs'))]))
@section('breadcrumb', request()->route()->getName())

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3">
    <div class="d-flex flex-row align-items-start">
        <a href="{{ route('bo.activity_logs.index', ['sort_col' => 'created_at', 'sort_way' => 'desc']) }}"
            class="btn btn-primary text-decoration-none m-0"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="{{ __('crud.helpers.list_all', ['model' => __('models.classes.activity_logs')]) }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        @include('breadcrumbs.breadcrumb-body', ['brParam' => $activitylogModel])
    </div>
</div>
<div class="row">
    <div class="col-12 mb-3">
        <fieldset class="border h-100 bg-white p-3">
            <legend>{{ __('texts.bo.title.general_informations') }}</legend>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover m-0">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="text-center align-middle w-50 fw-bold">{{ Str::singular(__('models.users')) }}</td>
                                    <td class="text-center align-middle w-50">
                                        @if (isset($activitylogModel->user))
                                        <a class="btn btn-sm btn-primary"
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
                                </tr>
                                <tr class="border-bottom">
                                    <td class="text-center align-middle w-50 fw-bold">{{ __('validation.attributes.event') }}</td>
                                    <td class="text-center align-middle w-50">
                                        <span class="text-{{ $activitylogModel->event->bootstrapClass() }}-emphasis bg-{{ $activitylogModel->event->bootstrapClass() }}-subtle border border-{{ $activitylogModel->event->bootstrapClass() }}-subtle rounded-3 p-1">
                                            {{ $activitylogModel->event->label() }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="text-center align-middle w-50 fw-bold">{{ __('validation.attributes.model') }}</td>
                                    <td class="text-center align-middle w-50">
                                        @if(isset($targetModel))
                                        <a class="btn btn-sm btn-primary"
                                            href="{{ route('bo.' . $targetModel->getTable() . '.edit', $targetModel->id) }}"
                                            title="{{ __('crud.actions_model.show', ['model' => Str::singular(__('models.' . $targetModel->getTable()))]) }}"
                                            data-bs="tooltip">
                                        @endif
                                        {{ $activitylogModel->model }}
                                        @if(isset($targetModel))
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="text-center align-middle w-50 fw-bold">{{ __('validation.attributes.created_at') }}</td>
                                    <td class="text-center align-middle w-50">
                                        <span class="badge bg-secondary">{{ $activitylogModel->created_at }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    @if (isset($activitylogModel->data))
    <div class="col-12 mb-3">
        <fieldset class="border h-100 bg-white p-3">
            <legend>{{ __('texts.bo.title.changes_made') }}</legend>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover m-0">
                            <thead>
                                <tr class="table-col-sorter border border-2 border-start-0 border-end-0 border-top-0 border-dark">
                                    <td>{{-- keep empty --}}</td>
                                    <td class="text-center align-middle w-50 fw-bold">{{ __('texts.bo.other.before') }}</td>
                                    <td class="text-center align-middle fw-bold">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </td>
                                    <td class="text-center align-middle w-50 fw-bold">{{ __('texts.bo.other.after') }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activitylogModel->data["type"] as $key => $dataType)
                                <tr class="border-bottom">
                                    <td class="text-center align-middle fw-bold">{{ $key }}</td>
                                    <td class="text-center align-middle w-25">
                                        @include('back.pages.activity_logs.show-changes', [
                                            'data' => $activitylogModel->data['old'][$key],
                                            'type' => $dataType,
                                        ])
                                    </td>
                                    <td class="text-center align-middle fw-bold">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </td>
                                    <td class="text-center align-middle w-25">
                                        @include('back.pages.activity_logs.show-changes', [
                                            'data' => $activitylogModel->data['new'][$key],
                                            'type' => $dataType,
                                        ])
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    @endif
</div>
@endsection
