@extends('layouts.frontend')
@section('title', __('meta.default_title'))
@section('description', __('meta.default_description'))
@section('keywords', __('meta.default_keyword'))

@section('content')
    <main class="main-home row justify-content-center align-items-center m-0 p-0 mx-md-5 px-md-5">
        <div class="col">
            <h1 class="w-fit title-font-regular text-center position-relative mx-auto mb-3 px-5 py-1">
                {{ config('app.name') }}
                <span class="angles"></span>
            </h1>
            @php
                $dataGame = [
                    'games' => $games,
                    'gamesCount' => count($games)
                ];
            @endphp
            <div class="games-list games-list-home" data-json='@json($dataGame)'>
            </div>
        </div>
    </main>
@endsection
