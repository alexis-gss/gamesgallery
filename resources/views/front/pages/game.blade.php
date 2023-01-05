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
    <div class="btn-scroll position-absolute bg-fourth rounded-2 p-1">
        <button class="btn text-first bg-third border-0 p-3">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
            </svg>
        </button>
    </div>
@endsection
