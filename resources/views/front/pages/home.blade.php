@extends('layouts.frontend')

@section('title', __('meta.default_title'))
@section('description', __('meta.default_description'))

@section('content')
<main class="main-home d-flex justify-content-center align-items-center m-0 p-0 mx-md-5 px-md-5">
    <div class="row w-100">
        <div class="col-12">
            <h1 class="w-fit title-font-regular text-center position-relative mx-auto mb-3 px-5 py-1">
                {{ config('app.name') }}
                <span class="angles"></span>
            </h1>
            @php
            $dataGame = [
                'games' => $games,
                'gamesCount' => count($games),
                'allTags' => $globalTags,
                'allFolders' => $globalFolders
            ];
            @endphp
            <div class="games-list bg-secondary rounded-2 p-2" data-json='@json($dataGame)'></div>
        </div>
        <div class="col-12">
            <div class="main-home-latest d-flex justify-content-start align-items-center">
                <p class="fw-bold m-0">{{ __('Last games added :') }}</p>
                <p class="d-inline-block text-truncate m-0">
                    {{ $gamesLatestString }}</p>
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
