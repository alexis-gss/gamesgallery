@extends('layouts.backend')

@section('title', __('meta.games_edition'))
@section('description', __('meta.games_edition_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <form action="{{ route('bo.games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
            <h1 class="h2 m-0 fw-bold">
                <a href="{{ route('bo.games.index') }}"
                    class="btn btn-primary h2 text-decoration-none m-0"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('form.return_list') }}">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 512 512">
                        <path d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z" />
                    </svg>
                </a>
                {{ __('form.game') }}
                <small class="text-muted h4">{{ __('form.edition') }}</small>
            </h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="submit"
                    class="btn btn-primary"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('form.save') }}">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 448 512">
                        <path d="M433.1 129.1l-83.9-83.9C342.3 38.32 327.1 32 316.1 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V163.9C448 152.9 441.7 137.7 433.1 129.1zM224 416c-35.34 0-64-28.66-64-64s28.66-64 64-64s64 28.66 64 64S259.3 416 224 416zM320 208C320 216.8 312.8 224 304 224h-224C71.16 224 64 216.8 64 208v-96C64 103.2 71.16 96 80 96h224C312.8 96 320 103.2 320 112V208z" />
                    </svg>
                </button>
            </div>
        </div>
        @include('back.games.form-inputs')
    </form>
@endsection
