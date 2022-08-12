@extends('layouts.frontend')
@section('title', __($game->name))
@section('description', __('show.description', ['game' => $game->name]))
@section('keywords', __('show.keywords', ['game' => $game->name]))

@section('content')
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
                @endif
            </div>
        @endif
    </article>
@endsection
