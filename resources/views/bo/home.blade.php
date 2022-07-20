@extends('layouts.backend')

@section('title', 'Back office')
@section('description', 'Page d\'accueil du Back office')
@section('metaIndex', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
        <h1 class="h2 m-0 fw-bold">{{ __('other.back_office') }}
            <small class="text-muted h4">{{ __('other.logs') }}</small>
        </h1>
    </div>
    <div class="row mt-3">
        <div class="col">
            {!! $changelog !!}
        </div>
    </div>
@endsection
