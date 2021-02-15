@extends('layouts.app', ['fullWidth' => true])

@section('title')
@lang('fortify::metatags.feedback.title')
@endsection

@section('content')

<x-ark-container>
    <div class="mx-auto flex flex-col items-center w-full text-center">
        <h1 class="max-w-sm md:max-w-none">@lang('fortify::pages.feedback.title')</h1>
        <p class="px-5 mt-4 sm:px-12 md:px-0 md:max-w-2xl">@lang('fortify::pages.feedback.description')</p>

        <livewire:profile.send-feedback-form />
    </div>
</x-ark-container>

@endsection
