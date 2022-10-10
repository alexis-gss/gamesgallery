@extends('layouts.backend')

@section('title', __('meta.users_edition'))
@section('description', __('meta.users_edition_desc'))
@section('metaIndex', 'noindex,nofollow')

@section('content')
    <form action="{{ route('bo.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 border-bottom">
            <h1 class="h2 m-0 fw-bold">
                <a href="{{ route('bo.users.index') }}"
                    class="btn btn-primary h2 text-decoration-none m-0"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('modification.return_list') }}">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill"
                        viewBox="0 0 512 512">
                        <path d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z" />
                    </svg>
                </a>
                {{ __('modification.user') }}
                <small class="text-muted h4">{{ __('modification.edition') }}</small>
            </h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="submit"
                    class="btn btn-primary"
                    data-bs="tooltip"
                    data-bs-placement="top"
                    title="{{ __('modification.save') }}">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill"
                        viewBox="0 0 448 512">
                        <path d="M433.1 129.1l-83.9-83.9C342.3 38.32 327.1 32 316.1 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V163.9C448 152.9 441.7 137.7 433.1 129.1zM224 416c-35.34 0-64-28.66-64-64s28.66-64 64-64s64 28.66 64 64S259.3 416 224 416zM320 208C320 216.8 312.8 224 304 224h-224C71.16 224 64 216.8 64 208v-96C64 103.2 71.16 96 80 96h224C312.8 96 320 103.2 320 112V208z" />
                    </svg>
                </button>
            </div>
        </div>
        @include('back.users.form-inputs')
    </form>
    <div class="row">
        <div class="col">
            <fieldset class="p-3">
                <legend>{{ __('form.account') }}</legend>
                <div class="row mb-3">
                    <div class="col-12 col-md-6 form-group">
                        <form action="{{ route('bo.users.destroy', $user->id) }}"
                            method="POST"
                            novalidate
                            onsubmit="popupDelete(event,
                            '{{ __('list.are_you_sure') }}',
                            '{{ __('list.data_lost', ['item' => $user->name]) }}',
                            '{{ __('list.form_confirm') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-sm btn-danger"
                                data-bs="tooltip"
                                data-bs-placement="top"
                                title="{{ __('list.delete_user') }}">
                                <svg width="16" height="16" fill="currentColor" class="bi bi-trash3-fill"
                                    viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                </svg>
                                <span>{{ __('list.delete_user') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
@endsection
