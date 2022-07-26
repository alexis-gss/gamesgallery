@extends('layouts.backend')

@section('title', __('modification.edition'))

@section('content')
    <form action="{{ route('bo.games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
            <h1 class="h2 m-0 fw-bold">
                <a href="{{ route('bo.games.index') }}" class="h2 text-decoration-none m-0" data-bs="tooltip"
                    data-bs-placement="top" title="{{ __('modification.return_list') }}">←</a>
                {{ __('modification.game') }}
                <small class="text-muted h4">{{ __('modification.edition') }}</small>
            </h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="submit" class="btn btn-primary" data-bs="tooltip" data-bs-placement="top"
                    title="{{ __('modification.edit_game') }}">{{ __('modification.save') }}</a>
            </div>
        </div>
        @include('bo.games.form-inputs')
    </form>
@endsection
