@component('mail::message')

## {{ $reason }}

{{ $message }}

@lang('fortify::mails.footer', ['applicationName' => config('app.name')])
@endcomponent
