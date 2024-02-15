@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => Str::of(__('models.rank'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => Str::of(__('models.rank'))->plural()]))

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        @include('breadcrumbs.breadcrumb-body')
    </div>
    <div class="row my-3">
        @can('update', \App\Models\Rank::class)
            <div class="col-12 form-group">
                <form class="d-flex justify-content-center align-items-center border-bottom flex-row pb-3" action="{{ route('bo.ranks.store') }}"
                    method="POST">
                    <span
                        class="input-group-text rounded-0 rounded-start border-end-0 border">{{ Str::of(__('validation.attributes.name'))->value() }}</span>
                    @csrf
                    @php
                        $data = [
                            'id' => 'ranksListInput',
                            'name' => 'ranks',
                            'value' => [],
                            'items' => $gameModels,
                            'placeholder' => __('bo_other_rank_add'),
                        ];
                    @endphp
                    <div class="w-100" id="belongs-to-many-dropdown" data-json='@json($data)'></div>
                    @include('back.modules.input-error', ['inputName' => 'tags'])
                    <button class="btn btn-primary rounded-0 rounded-end" data-bs-tooltip="tooltip" type="submit"
                        title="{{ __('bo_tooltip_ranking_add_game') }}">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </form>
            </div>
            <div class="col-12 mt-3">
                @php
                    $data = [
                        'id' => 'gamesRanking',
                        'rankModels' => $rankModels,
                    ];
                @endphp
                <div id="games-ranking" data-json='@json($data)'></div>
            </div>
        @endcan
    </div>
@endsection
