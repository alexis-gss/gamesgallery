@extends('layouts.backend')

@section('title', __('modification.creation'))

@section('content')
    <form action="{{ route('bo.folders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
            <h1 class="h2 m-0 fw-bold">
                <a href="{{ route('bo.folders.index') }}" class="h2 text-decoration-none m-0"
                    title="{{ __('modification.return_list') }}">←</a>
                {{ __('modification.folder') }}
                <small class="text-muted h4">{{ __('modification.creation') }}</small>
            </h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="submit" class="btn btn-primary"
                    title="{{ __('modification.add_folder') }}">{{ __('modification.save') }}</a>
            </div>
        </div>
        @include('bo.folders.form-inputs')
    </form>
@endsection
