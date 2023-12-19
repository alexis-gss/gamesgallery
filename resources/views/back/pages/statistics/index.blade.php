@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => Str::of(__('models.statistic'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => Str::of(__('models.statistic'))->plural()]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center border-bottom pb-3">
    @include('breadcrumbs.breadcrumb-body')
</div>
<!-- LATEST DATA UPDATED -->
<div class="row py-3">
    <div class="col-12 py-0">
        <div class="card card-stats border-0">
            <ul class="nav nav-tabs" id="tab-latest-data-updated" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane"
                        type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>
                        {{ __('Latest data updated') }}
                    </button>
                </li>
                @foreach($navLinks as $navLink)
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if($loop->first) active @endif" id="{{ $navLink['name'] }}-tab" data-bs-toggle="tab"
                        data-bs-target="#{{ $navLink['name'] }}-tab-pane" type="button" role="tab"
                        aria-controls="{{ $navLink['name'] }}-tab-pane" aria-selected="true">
                        {{ Str::of($navLink['translation'])->ucFirst() }}
                    </button>
                </li>
                @endforeach
            </ul>
            <div class="tab-content border border-top-0 rounded-bottom" id="tab-latest-data-updated-content">
                @foreach($navLinks as $navLink)
                <div class="tab-pane fade @if($loop->first) active show @endif" id="{{ $navLink['name'] }}-tab-pane" role="tabpanel"
                    aria-labelledby="{{ $navLink['name'] }}-tab">
                    <div class="card-body bg-body-tertiary">
                        <table class="table table-hover m-0">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="text-center align-middle bg-transparent">
                                        {{ Str::of($navLink['field'])->ucfirst() }}
                                    </td>
                                    <td class="text-center align-middle bg-transparent">
                                        {{ $navLink['value'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 text-center align-middle bg-transparent">
                                        {{ Str::of(__('validation.attributes.updated_at'))->ucfirst() }}
                                    </td>
                                    <td class="border-0 text-center align-middle bg-transparent">
                                        <span class="badge bg-secondary">{{ $navLink['model']->updated_at->isoFormat('LLLL') }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- CHARTS -->
<div class="row">
    <div class="col-12 mb-3">
        <div class="card bg-body-tertiary border-top p-3 p-md-5">
            @include('back.pages.statistics.chart-activities')
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="card bg-body-tertiary border-top p-3 p-md-5">
            @include('back.pages.statistics.chart-games-by-tags')
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="card bg-body-tertiary border-top p-3 p-md-5">
            @include('back.pages.statistics.chart-games-by-folders')
        </div>
    </div>
</div>
@endsection
