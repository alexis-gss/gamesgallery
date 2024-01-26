@extends('front.layout', ['brParam' => $gameModel])

@section('title', $gameModel->name ?? __('fo_home_title'))
@section('description', __('fo_description', ['game' => $gameModel->name]) ?? __('fo_home_description'))
@section('breadcrumb',
    request()->route()->getName())

@section('content')
    <main class="main-page row">
        <div class="col-12">
            @if (isset($gameModel))
                <div class="my-5">
                    <h1 class="title-font-regular position-relative mx-auto mb-3 w-fit px-5 py-1 text-center">
                        {{ $gameModel->name }}
                        <span class="d-none d-sm-block angles"></span>
                    </h1>
                    <div class="d-flex justify-content-center align-items-center user-select-none w-100 flex-row text-center">
                        <a class="bg-primary rounded-2 text-decoration-none border-0 px-2 text-white" data-bs-tooltip="tooltip"
                            data-bs-placement="top" href="{{ route('fo.games.index') }}" title="{{ __('bo_other_back_home') }}">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <span class="mx-1">-</span>
                        <p class="rounded-2 m-0 px-2 py-0 text-white" style="background-color:{{ $gameModel->folder->color }}">
                            {{ $gameModel->folder->name }}
                        </p>
                        @if (count($gameModel->tags) > 0)
                            <span class="ms-1">-</span>
                            @foreach ($gameModel->tags as $tag)
                                <p class="bg-primary rounded-2 my-0 ms-1 px-2 py-0 text-white">
                                    {{ $tag->name }}
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>
                @php
                    $dataGame = [
                        'gameName' => $gameModel->name,
                        'gameSlug' => $gameModel->slug,
                        'gamePictures' => $gamePictures,
                    ];
                @endphp
                <div class="game-pictures position-relative" data-json='@json($dataGame)'></div>
            @endif
        </div>
    </main>
@endsection
