@extends('layouts.frontend')
@section('title', (isset($game) ? $game->name : __('meta.default_title')))
@section('description', (isset($game) ? __('meta.description',  ['game' =>  $game->name]) :  __('meta.default_description')))
@section('keywords', __('meta.keywords', ['game' => (isset($game) ? $game->name : __('meta.default_keyword'))]))

@section('content')
    <!-- Navigation -->
    @include('front.layouts.header')

    <!-- Content -->
    <article>
        @if (isset($game))
            <h2>{{ $game->name }}</h2>
            <div class="wrapper">
                @if (isset($game->pictures))
                    @foreach ($game->pictures as $picture)
                        <div class="content">
                            <img class="image" src="{{ asset('assets/images/load.gif') }}" data-src="{{ asset($picture) }}"
                                alt="{{ $game->pictures_alt }}">
                        </div>
                    @endforeach
                @else
                    <div class="content">
                        <img class="image image-soon" src="{{ asset('assets/images/load.gif') }}"
                            data-src="{{ asset('assets/images/visual-soon.png') }}" alt="{{ __('show.default_image') }}">
                    </div>
                @endif
            </div>
        @endif
    </article>
@endsection
