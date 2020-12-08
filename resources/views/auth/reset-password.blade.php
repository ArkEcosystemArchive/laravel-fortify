@extends('layouts.app')

@slot('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endslot

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.reset_password')],
    ]" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto my-8 md:w-3/4 lg:w-3/5 xl:w-1/2">
            <h1 class="mx-4 text-2xl font-bold md:text-4xl md:mx-8 xl:mx-16">@lang('fortify::auth.reset-password.page_header')</h1>

            <div class="mt-5 lg:mt-8">
                <livewire:auth.reset-password-form />
            </div>
        </div>
    </div>
@endsection
