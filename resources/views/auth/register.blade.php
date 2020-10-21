@extends('layouts.app')

@section('title')
    @lang('fortify::metatags.register')
@endsection

@section('back-bar')
    <x-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('fortify::menu.sign-in')],
        ['label' => trans('fortify::menu.sign-up')],
    ]" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto my-8 md:w-3/4 lg:w-3/5 xl:w-1/2">
            <h1 class="mx-4 text-2xl font-bold md:text-4xl md:mx-8 xl:mx-16">Sign up</h1>
            <div class="mx-4 mt-2 text-theme-secondary-700 md:mx-8 xl:mx-16">Sign up to MarketSquare and connect with a growing community of like-minded blockchain enthusiasts and developers.</div>

            <div class="mt-5 lg:mt-8">
                <livewire:auth.register-form />
            </div>
        </div>
    </div>
@endsection
