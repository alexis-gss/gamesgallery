@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => Str::of(__('models.rank'))->plural()]))
@section('description', __('crud.meta.all_models_list', ['model' => Str::of(__('models.rank'))->plural()]))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    @include('breadcrumbs.breadcrumb-body')
</div>
<div class="row my-3">
    @can('update', \App\Models\Rank::class)
    <div class="col-12 form-group">
        <form action="{{ route('bo.ranks.store') }}" method="POST" class="d-flex flex-row justify-content-center align-items-center border-bottom pb-3">
            <span class="input-group-text rounded-0 rounded-start border border-end-0">{{ Str::of(__('validation.attributes.name'))->value() }}</span>
            @csrf
            @php
            $data = [
                'name'        => 'ranks',
                'value'       => [],
                'items'       => $gameModels,
                'placeholder' => __('bo_other_rank_add'),
            ];
            @endphp
            <div id="belongs-to-many-dropdown" data-json='@json($data)' class="w-100"></div>
            @include('back.modules.input-error', ['inputName' => 'tags'])
            <button class="btn btn-primary rounded-0 rounded-end" type="submit">
                <i class="fa-solid fa-plus"></i>
            </button>
        </form>
    </div>
    <div class="col-12 mt-3">
        @php
        $data = [
            'id'         => 'games',
            'rankModels' => $rankModels,
        ]
        @endphp
        <div id="games-ranking" data-json='@json($data)'></div>
    </div>
    @endcan
</div>
@endsection
