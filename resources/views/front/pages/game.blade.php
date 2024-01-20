@extends('front.layout', ['brParam' => $gameModel])

@section('title', (isset($gameModel) ? $gameModel->name : __('fo_default_title')))
@section('description', (isset($gameModel) ? __('fo_description',  ['game' =>  $gameModel->name]) :  __('fo_default_description')))
@section('breadcrumb', request()->route()->getName())

@section('content')
<main class="main-page row">
    <div class="col-12">
        @if (isset($gameModel))
        <div class="my-5">
            <h1 class="w-fit title-font-regular text-center position-relative mx-auto mb-3 px-5 py-1">
                {{ $gameModel->name }}
                <span class="d-none d-sm-block angles"></span>
            </h1>
            <div class="d-flex flex-row justify-content-center align-items-center user-select-none text-center w-100">
                <a href="{{ route('fo.games.index') }}"
                    class="bg-primary border-0 text-white rounded-2 px-2 text-decoration-none"
                    title="{{ __('bo_other_back_home') }}"
                    data-bs="tooltip"
                    data-bs-placement="top">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <span class="mx-1">-</span>
                <p class="text-white rounded-2 px-2 py-0 m-0" style="background-color:{{ $gameModel->folder->color }}">
                    {{ $gameModel->folder->name }}
                </p>
                @if (count($gameModel->tags) > 0)
                <span class="ms-1">-</span>
                @foreach ($gameModel->tags as $tag)
                <p class="bg-primary text-white rounded-2 px-2 py-0 ms-1 my-0">
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
            'gamePictures' => $gamePictures
        ];
        @endphp
        <div class="game-pictures position-relative" data-json='@json($dataGame)'></div>
        @endif
    </div>
</main>
@endsection
