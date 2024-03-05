{{-- blade-formatter-disable --}}
@component('mail::message')

# {{ __('auth.email_hello') }}

{{ __('auth.email_reset_complete') }}

{{ __('auth.email_new_connection') }}
@component('mail::button', ['url' => config('app.url') . '/bo'])
<strong>{{ __('auth.login_btn') }}</strong>
@endcomponent

{{ config('app.name') }}.

<hr>

<small>{{ __('auth.email_cant_visualise', ['actionText' => __('auth.login_btn')]) }}
<a href="{{ config('app.url') }}/bo" target="_blank">{{ config('app.url') }}/bo</a></small>

@endcomponent
