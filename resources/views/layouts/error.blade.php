@extends(Request::is('bo/*') ? 'layouts.backend' : 'layouts.frontend')
@section('title', __('errors.error_title'))
@section('description', __('errors.error_message'))

@section('content')
    <div clas="row">
        <h1>@yield('errorTitle')</h1>
        <p>@yield('errorMessage')</p>
        <p class="text-muted">error code : @yield('errorCode')</p>
        <a href="{{ Request::is('bo/*') ? route('bo.homepage') : route('homepage') }}">Let's go back to the homepage !</a>
    </div>
@endsection
