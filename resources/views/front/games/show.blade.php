@extends('layouts.frontend')
@section('title', __('Home'))
@section('description', __('metadesc_home'))
@section('keywords', __('metatag_home'))

@include('layouts.frontend.nav')
@section('content')
    <main>
        @if (isset($game))
            <p>{{ $game->name }}</p>
            @if (isset($game->pictures))
                @foreach ($game->pictures as $picture)
                    <img src="{{ asset($picture) }}" alt="{{ $game->pictures_alt }}" style="width:100px;">
                @endforeach
            @endif
        @endif
    </main>
@endsection
