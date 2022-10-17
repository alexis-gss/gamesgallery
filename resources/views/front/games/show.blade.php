@extends('layouts.frontend')
@section('title', (isset($game) ? $game->name : __('meta.default_title')))
@section('description', (isset($game) ? __('meta.description',  ['game' =>  $game->name]) :  __('meta.default_description')))
@section('keywords', __('meta.keywords', ['game' => (isset($game) ? $game->name : __('meta.default_keyword'))]))

@section('content')
    <main class="row">
        <div class="col-12">
            @if (isset($game))
                <h1 class="text-center my-5">{{ $game->name }}</h1>
                @php
                    $dataGame = [
                        'game' => $game,
                        'gamePictures' => $gamePictures,
                    ];
                @endphp
                <div class="game-pictures position-relative" data-json='@json($dataGame)'></div>
            @endif
        </div>
    </main>
@endsection
