@extends('layouts.frontend', ['brParam' => $game])

@section('title', (isset($game) ? $game->name : __('texts.fo.default_title')))
@section('description', (isset($game) ? __('texts.fo.description',  ['game' =>  $game->name]) :  __('texts.fo.default_description')))
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
            <div class="d-flex flex-row justify-content-center align-items-center user-select-none text-center w-100">
                <a href="{{ route('fo.homepage') }}"
                    class="bg-primary border-0 text-white rounded-2 px-2 text-decoration-none"
                    title="{{ __('texts.bo.other.back_home') }}"
                    data-bs="tooltip"
                    data-bs-placement="top">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <span class="mx-1">-</span>
                <p class="text-white rounded-2 px-2 py-0 m-0" style="background-color:{{ $game->folder->color }}">
                    {{ $game->folder->name }}
                </p>
                @if (count($game->tags) > 0)
                <span class="ms-1">-</span>
                @foreach ($game->tags as $tag)
                <p class="bg-primary text-white rounded-2 px-2 py-0 ms-1 my-0">
                    {{ $tag->name }}
                </p>
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
