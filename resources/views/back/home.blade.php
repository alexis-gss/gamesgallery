@extends('layouts.backend')

@section('title', __('meta.back_office'))
@section('description', __('meta.back_office_desc'))
@section('keywords', 'noindex,nofollow')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
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
