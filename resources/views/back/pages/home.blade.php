@extends('back.layout')

@section('title', __('bo_other_back_office'))
@section('description', __('bo_other_back_office_desc'))

@section('content')
    <section id="home">
        <div class="border-bottom pb-3">
            <h1 class="h2 fw-bold m-0">{{ __('bo_other_back_office') }}</h1>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="card bg-body-tertiary p-5 text-center">
                    <h5>
                        {{ __('bo_other_home_hello', ['first_name' => auth()->user()->first_name, 'last_name' => auth()->user()->last_name]) }}
                    </h5>
                    <p class="m-0">
                        {{ __('bo_other_home_welcome') }}
                    </p>
                    <p class="m-0">
                        {{ __('bo_other_home_contact') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="border-bottom py-3">
            <h2 class="h2 fw-bold m-0">{{ __('bo_other_changelog') }}</h2>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card changelog bg-body-tertiary overflow-y-scroll p-5">
                    {!! $changelog !!}
                </div>
            </div>
        </div>
    </section>
@endsection
