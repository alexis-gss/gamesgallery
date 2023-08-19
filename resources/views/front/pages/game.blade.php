@extends('layouts.frontend', ['brParam' => $game])

@section('title', (isset($game) ? $game->name : __('meta.default_title')))
@section('description', (isset($game) ? __('meta.description',  ['game' =>  $game->name]) :  __('meta.default_description')))
@section('breadcrumb', request()->route()->getName())

@section('content')
<main class="main-page row">
    <div class="col-12">
        @if (isset($game))
        <div class="my-5">
            <h1 class="w-fit title-font-regular text-center position-relative mx-auto mb-3 px-5 py-1">
                {{ $game->name }}
                <span class="angles"></span>
            </h1>
            <div class="d-inline-block user-select-none text-center w-100">
                <a href="{{ route('fo.homepage') }}" class="text-decoration-none">
                    <button class="badge bg-primary border-0 text-white rounded-2 px-2"
                        title="{{ __('list.back_home') }}"
                        data-bs="tooltip"
                        data-bs-placement="top">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </a>
                <span>-</span>
                <span class="badge text-white rounded-2 px-2 py-1" style="background-color:{{ $game->folder->color }}">{{ $game->folder->name }}</span>
                @if (count($game->tags) > 0)
                <span>-</span>
                @foreach ($game->tags as $tag)
                <span class="badge bg-primary text-white rounded-2 px-2 py-1 my-1">{{ $tag->name }}</span>
                @endforeach
                @endif
            </div>
        </div>
        @php
        $dataGame = [
            'gameName' => $game->name,
            'gameSlug' => $game->slug,
            'gamePictures' => $gamePictures
        ];
        @endphp
        <div class="game-pictures position-relative" data-json='@json($dataGame)'></div>
        @endif
    </div>
</main>
@endsection
