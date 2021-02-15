@extends('layouts.app', ['fullWidth' => true])

@section('title')
@lang('fortify::metatags.feedback_thank_you')
@endsection

@section('content')

<x-generic.container>
    <div class="mx-auto flex flex-col items-center w-full text-center">
        <img src="{{ asset('/images/profile/feedback/thank-you.svg') }}" alt="">

        <h1 class="px-8 mt-8 max-w-xs sm:max-w-none">@lang('fortify::pages.feedback_thank_you.title')</h1>
        <p class="mt-4 max-w-xs leading-relaxed sm:max-w-lg sm:px-4 lg:max-w-none lg:px-0">@lang('fortify::pages.feedback_thank_you.description')</p>

        <a href="{{ route('home') }}" class="mt-8 w-full sm:w-auto button-secondary">@lang('fortify::pages.feedback_thank_you.home_page')</a>
    </div>
</x-generic.container>

@endsection
