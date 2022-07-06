@extends('layouts.backend')

@section('title', __('Edition'))

@section('content')
    <form action="{{ route('bo.folders.update', $folder->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
            <h1 class="h2 m-0">
                <a href="{{ route('bo.folders.index') }}" class="h2 text-decoration-none m-0"
                    title="{{ __('Return_list') }}"> ← </a>
                {{ __('Folders') }}
                <small class="text-muted">{{ __('Edition') }}</small>
            </h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="submit" class="btn btn-primary" title="{{ __('Edit_folder') }}">{{ __('Save') }}</a>
            </div>
        </div>
        @include('bo.folders.form-inputs')
    </form>
@endsection
