@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => str(__('models.statistic'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => str(__('models.statistic'))->plural()]))

@section('content')
    <section id="statistics">
        <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
            @include('breadcrumbs.breadcrumb-body')
        </div>
        <!-- LATEST DATA UPDATED -->
        @if (count($navLinks))
            <div class="row py-3">
                <div class="col-12 py-0">
                    @include('back.pages.statistics.partials.latest-data')
                </div>
            </div>
        @endif
        <!-- CHARTS -->
        <div class="row">
            @if (count($activityModels))
                <div class="col-12 mb-3">
                    <div class="card bg-body-tertiary border-top p-md-5 p-3">
                        @include('back.pages.statistics.partials.chart-activities')
                    </div>
                </div>
            @endif
            @if (count($globalTags))
                <div class="col-12 mb-3">
                    <div class="card bg-body-tertiary border-top p-md-5 p-3">
                        @include('back.pages.statistics.partials.chart-games-by-tags')
                    </div>
                </div>
            @endif
            @if (count($globalFolders))
                <div class="col-12 mb-3">
                    <div class="card bg-body-tertiary border-top p-md-5 p-3">
                        @include('back.pages.statistics.partials.chart-games-by-folders')
                    </div>
                </div>
            @endif
            @if (count($picturesRatings))
                <div class="col-12 mb-3">
                    <div class="card bg-body-tertiary border-top p-md-5 p-3">
                        @include('back.pages.statistics.partials.chart-pictures-by-ratings')
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
