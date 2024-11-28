@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => str(__('models.statistic'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => str(__('models.statistic'))->plural()]))

@section('content')
    <section id="statistics">
        <div class="d-flex justify-content-between flex-md-nowrap align-items-center flex-wrap">
            <x-breadcrumbs.breadcrumb-body />
        </div>
        {{-- LATEST DATA UPDATED --}}
        @if (count($navLinks))
            <div class="row py-3">
                <div class="col-12 py-0">
                    <x-back.statistics.latest-data :navLinks="$navLinks" />
                </div>
            </div>
        @endif
        <div class="row">
            {{-- CHARTS --}}
            @php
                $array = [
                    ['models' => $activityModels, 'component' => 'back.statistics.chart-activities'],
                    ['models' => $globalTags, 'component' => 'back.statistics.chart-games-by-tags'],
                    ['models' => $globalFolders, 'component' => 'back.statistics.chart-games-by-folders'],
                ]
            @endphp
            @foreach($array as $item)
                @if ($item['models']->isNotEmpty())
                    <div class="col-12 mb-3">
                        <div class="card bg-body-tertiary border-top rounded-3 p-md-5 p-3">
                            <x-dynamic-component :component="$item['component']" :models="$item['models']"
                                :dateLastDays="$dateLastDays" :dateLastDaysFormated="$dateLastDaysFormated" />
                        </div>
                    </div>
                @endif
            @endforeach
            {{-- COUNTERS --}}
            <div class="col-12">
                <div class="card bg-body-tertiary border-top rounded-3 p-md-5 p-3">
                    <div class="row">
                        @php
                            $arrayCounters = [
                                ['models' => $ratingModels, 'component' => 'back.statistics.most-liked-pictures'],
                                ['models' => $visitModels, 'component' => 'back.statistics.most-visited-pages'],
                            ]
                        @endphp
                        @foreach($arrayCounters as $item)
                            <div class="col-12 col-xxl-6">
                                <x-dynamic-component :component="$item['component']" :models="$item['models']" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
