@extends('layouts.frontend')
@section('title', __('Home'))
@section('description', __('metadesc_home'))
@section('keywords', __('metatag_home'))

@section('content')
    <a href="{{ route('homepage') }}">Home</a>
    <main>
        erreur 404 là
    </main>
@endsection
