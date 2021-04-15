@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="password.forgot" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.password_reset_email')],
    ]" />
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.component-heading" />

    <div class="max-w-xl py-8 mx-auto">
        <div class="px-8">
            <x-ark-flash />
        </div>

        <div class="mt-5 lg:mt-8">
            <form
                method="POST"
                action="{{ route('password.email') }}"
                class="flex flex-col px-4 py-8 mx-4 border-2 rounded-lg sm:px-8 border-theme-secondary-200"
            >
                @csrf

                <div class="mb-8">
                    <div class="flex flex-1">
                        <x-ark-input
                            type="email"
                            name="email"
                            label="Email"
                            autocomplete="email"
                            class="w-full"
                            :autofocus="true"
                            :required="true"
                        />
                    </div>
                </div>

                <div class="flex flex-col-reverse items-center justify-between space-y-4 md:space-y-0 md:flex-row">
                    <div class="flex-1 mt-8 md:mt-0">
                        <a href="{{ route('login') }}" class="link">@lang('fortify::actions.cancel')</a>
                    </div>

                    <button type="submit" class="w-full button-secondary md:w-auto">
                        @lang('fortify::auth.forgot-password.reset_link')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
