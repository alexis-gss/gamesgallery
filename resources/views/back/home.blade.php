@extends('layouts.backend')

@section('title', __('meta.back_office'))
@section('description', __('meta.back_office_desc'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    <h1 class="h2 m-0 fw-bold">{{ __('other.back_office') }}</h1>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="text-center">
            <h5>{{ __('other.home_hello', ['name' => Auth::user()->name]) }}</h5>
            <p class="m-0">
                {{ __('other.home_welcome') }}
            </p>
            <p class="m-0">
                {{ __('other.home_contact') }}
            </p>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 border-bottom">
    <h2 class="h2 m-0 fw-bold">{{ __('other.changelog') }}</h2>
</div>
<div class="row mt-3">
    <div class="col-12 changelog overflow-y-scroll">
        {!! $changelog !!}
    </div>
</div>
@endsection
