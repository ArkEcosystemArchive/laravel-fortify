@extends('layouts.app')

@section('content')
<div class="flex max-w-md p-8 mx-auto my-6 bg-white rounded-lg">
    <div class="flex flex-col w-full text-center">
        <img class="mb-5" src="/images/auth/verified-email.svg" />
        <h2>@lang('fortify::auth.verified.page_header')</h2>
        <p>
            @lang('fortify::auth.verified.page_description')
        </p>

        <div class="flex justify-center mt-5">
            <a href="{{ route('home') }}" class="button-primary">@lang('fortify::auth.verified.cta')</a>
        </div>
    </div>
</div>
@endsection
