@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => Str::of(__('models.statistic'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => Str::of(__('models.statistic'))->plural()]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center border-bottom pb-3">
    @include('breadcrumbs.breadcrumb-body')
</div>
<div class="row py-3">
    <div class="col-12 col-md-3 py-0">
        <a href="{{ route('bo.folders.edit', $latestModels['App\Models\Folder']) }}" class="card card-stats text-decoration-none p-0">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="card-body text-center">
                    <p class="border-bottom fw-bold m-0 pb-1">{{ __('texts.bo.other.stats_latest_model', ['model' => __('models.folder')]) }}</p>
                    <p class="card-title m-0">{{ $latestModels['App\Models\Folder']->name }}</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-6 py-2 p-md-0">
        <a href="{{ route('bo.games.edit', $latestModels['App\Models\Game']) }}" class="card card-stats overflow-hidden text-decoration-none p-0">
            <div class="d-flex justify-content-center align-items-center h-100">
                @if (isset($latestModels['App\Models\Game']->pictures[0]))
                <div class="d-none d-md-block position-relative overflow-hidden w-fit h-100">
                    <img class="w-auto h-100"
                        src="{{ request()->root() . "/storage/documents/" . $latestModels['App\Models\Game']->slug . "/" . $latestModels['App\Models\Game']->pictures[0]->uuid . "." . $latestModels['App\Models\Game']->pictures[0]->type }}"
                        alt="{{ __('alt') }}">
                    <span class="card-filter position-absolute top-0 end-0 h-100"></span>
                </div>
                @endif
                <div class="flex-fill">
                    <div class="card-body text-center @if (isset($latestModels['App\Models\Game']->picture[0])) text-md-start @endif">
                        <p class="border-bottom fw-bold m-0 pb-1">{{ __('texts.bo.other.stats_latest_model', ['model' => __('models.game')]) }}</p>
                        <p class="card-title">{{ $latestModels['App\Models\Game']->name }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-3 py-0">
        <a href="{{ route('bo.tags.edit', $latestModels['App\Models\Tag']) }}" class="card card-stats text-decoration-none p-0">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="card-body text-center">
                    <p class="border-bottom fw-bold m-0 pb-1">{{ __('texts.bo.other.stats_latest_model', ['model' => __('models.tag')]) }}</p>
                    <p class="card-title m-0">{{ $latestModels['App\Models\Tag']->name }}</p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-3">
        <div class="card border-top p-5">
            @include('back.pages.statistics.chart-activities')
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="card border-top p-5">
            @include('back.pages.statistics.chart-games-by-tags')
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="card border-top p-5">
            @include('back.pages.statistics.chart-games-by-folders')
        </div>
    </div>
</div>
@endsection
