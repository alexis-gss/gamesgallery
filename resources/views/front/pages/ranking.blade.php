@extends('front.layout', ['brParam' => $rankModels])

@section('title', __('fo_default_title'))
@section('description', __('fo_default_description'))
@section('breadcrumb', request()->route()->getName())

@section('content')
<main class="main-page m-0 p-0 mx-md-5 px-md-5">
    <div class="row w-100">
        <div class="col-12">
            <div class="my-5">
                <h1 class="w-fit title-font-regular text-center position-relative mx-auto mb-3 px-5 py-1">
                    {{ __('fo_ranking') }}
                    <span class="angles"></span>
                </h1>
                <div class="d-flex flex-row justify-content-center align-items-center user-select-none text-center w-100">
                    <a href="{{ route('fo.homepage') }}"
                        class="bg-primary border-0 text-white rounded-2 px-2 text-decoration-none"
                        title="{{ __('bo_other_back_home') }}"
                        data-bs="tooltip"
                        data-bs-placement="top">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <span class="mx-1">-</span>
                    <p class="bg-primary text-white rounded-2 px-2 py-0 m-0">
                        {{ Str::of(__('fo_ranking_details', ['number' => count($rankModels)]))->ucFirst() }}
                    </p>
                </div>
            </div>
            @if (isset($rankModels))
            <ul class="bg-secondary rounded p-2">
                @foreach ($rankModels as $key => $rankModel)
                <li class="list-group-item border-0 rounded-2 bg-transparent p-0">
                    <a href="{{ route('fo.games.show', $rankModel->game->slug) }}" class="position-relative d-flex flex-row justify-content-start align-items-center btn border-0 text-white text-decoration-none w-100 p-1">
                        <div class="d-flex flex-row justify-content-start align-items-center">
                            <span class="list-group-item-span z-0" style="background-color: {{ $rankModel->game->folder()->firstOrFail()->color }};"></span>
                            <span class="title-font-regular ps-1 z-1">
                                @php $rank = $key + 1; @endphp
                                {{ (($rank < 10) ? (0 . $rank) : $rank) }}&nbsp;-&nbsp;
                            </span>
                        </div>
                        <p class="z-1 my-1">{{ $rankModel->name }}</p>
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</main>
@endsection
