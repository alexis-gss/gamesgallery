{{-- blade-formatter-disable --}}
@component('mail::message')

# {{ __('auth.email_hello') }}

{{ __('auth.email_get_reset_password') }}
{{ __('auth.email_reset_link_expire', ['count' => config('auth.passwords.users.expire')]) }}

{{ __('auth.email_button_redirect') }}
@component('mail::button', ['url' => route('bo.password.reset', $data->token)])
<strong>{{ __('auth.email_reset_password') }}</strong>
@endcomponent

{{ __('auth.email_wrong_destination') }}

{{ config('app.name') }}.

<hr>

<small>{{ __('auth.email_cant_visualise', ['actionText' => __('auth.email_reset_password')]) }}
<a href="{{ route('bo.password.reset', $data->token) }}" target="_blank">{{ route('bo.password.reset', $data->token) }}</a></small>

@endcomponent
