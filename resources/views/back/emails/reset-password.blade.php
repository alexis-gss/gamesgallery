{{-- blade-formatter-disable --}}
@component('mail::message')

# {{ __('auth.email_hello') }}

{{ __('auth.email_reset_complete') }}

{{ config('app.name') }}.

@endcomponent
