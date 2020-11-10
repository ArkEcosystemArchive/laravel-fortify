@extends('layouts.app')

@section('title')
    {{ $metaTitle ?? trans('fortify::metatags.register') }}
@endsection

@section('back-bar')
    <x-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('menu.sign_in') ?? trans('fortify::menu.sign_in')],
        ['label' => trans('menu.sign_up') ?? trans('fortify::menu.sign_up')],
    ]" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto my-8 md:w-3/4 lg:w-3/5 xl:w-1/2">
            <h1 class="mx-4 text-2xl font-bold md:text-4xl md:mx-8 xl:mx-16">@lang('fortify::auth.register.page_header')</h1>
            <div class="mx-4 mt-2 text-theme-secondary-700 md:mx-8 xl:mx-16">{{ trans('auth.register.page_description') ?? trans('fortify::auth.register.page_description') }}</div>

            <div class="mt-5 lg:mt-8">
                <livewire:auth.register-form />
            </div>
        </div>
    </div>
@endsection
