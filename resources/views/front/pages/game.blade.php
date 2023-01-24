@extends('layouts.frontend')
@section('title', (isset($game) ? $game->name : __('meta.default_title')))
@section('description', (isset($game) ? __('meta.description',  ['game' =>  $game->name]) :  __('meta.default_description')))
@section('keywords', __('meta.keywords', ['game' => (isset($game) ? $game->name : __('meta.default_keyword'))]))

@section('content')
    <main class="main-page row">
        <div class="col-12">
            @if (isset($game))
                <div class="my-5">
                    <h1 class="w-fit title-font-regular text-center position-relative mx-auto mb-3 px-5 py-1">
                        {{ $game->name }}
                        <span class="angles"></span>
                    </h1>
                    <div class="d-inline-block text-center w-100">
                        @foreach ($game->tags as $tag)
                            <span class="badge bg-third text-white rounded-2 px-2 py-1">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
                @php
                    $dataGame = [
                        'game' => $game,
                        'gamePictures' => $gamePictures
                    ];
                @endphp
                <div class="game-pictures position-relative" data-json='@json($dataGame)'>
                </div>
            @endif
        </div>
    </main>
@endsection
