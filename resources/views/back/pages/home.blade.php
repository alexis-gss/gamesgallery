@extends('back.layout')

@section('title', __('bo_other_back_office'))
@section('description', __('bo_other_back_office_desc'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 border-bottom">
    <h1 class="h2 m-0 fw-bold">{{ __('bo_other_back_office') }}</h1>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card bg-body-tertiary text-center p-5">
            <h5>{{ __('bo_other_home_hello', ['first_name' => auth()->user()->first_name, 'last_name' => auth()->user()->last_name]) }}</h5>
            <p class="m-0">
                {{ __('bo_other_home_welcome') }}
            </p>
            <p class="m-0">
                {{ __('bo_other_home_contact') }}
            </p>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 border-bottom">
    <h2 class="h2 m-0 fw-bold">{{ __('bo_other_changelog') }}</h2>
</div>
<div class="row mt-3">
    <div class="col-12">
        <div class="card changelog bg-body-tertiary overflow-y-scroll p-5">
            {!! $changelog !!}
        </div>
    </div>
</div>
@endsection
