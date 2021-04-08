@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="sign-in" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'home', 'label' => trans('fortify::menu.home')],
        ['label' => trans('fortify::menu.sign_in')],
    ]" />
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.component-heading" />

    <div class="max-w-xl py-8 mx-auto">
        <form
            method="POST"
            action="{{ route('login') }}"
            class="flex flex-col px-4 py-8 mx-4 border-2 rounded-lg sm:px-8 border-theme-secondary-200"
        >
            @csrf

            <div class="flex flex-col space-y-8">
                @if (session('status'))
                    <x-ark-alert type="success">
                        <x-slot name="message">
                            {{ session('status') }}
                        </x-slot>
                    </x-ark-alert>
                @endif

                <div class="flex flex-1">
                    @php
                        $username = \Laravel\Fortify\Fortify::username();
                        $usernameAlt = Config::get('fortify.username_alt');
                        $type = 'text';

                        if ($usernameAlt) {
                            $label = trans('fortify::forms.'.$username).' or '.trans('fortify::forms.'.$usernameAlt);
                        } else {
                            $label = trans('fortify::forms.'.$username);
                            if ($username === 'email') {
                                $type = 'email';
                            }
                        }
                    @endphp

                    <x-ark-input
                        :type="$type"
                        :name="$username"
                        :label="$label"
                        autocomplete="email"
                        class="w-full"
                        :autofocus="true"
                        :value="old($username)"
                        :errors="$errors"
                    />
                </div>

                <div class="flex flex-1">
                    <x-ark-input
                        type="password"
                        name="password"
                        :label="trans('fortify::forms.password')"
                        autocomplete="password"
                        class="w-full"
                        :errors="$errors"
                    />
                </div>

                <div class="flex flex-col-reverse items-center justify-between space-y-4 md:space-y-0 md:flex-row">
                    @if(Route::has('password.request'))
                        <div class="flex-1 mt-8 md:mt-0">
                            <a href="{{ route('password.request') }}" class="link">@lang('fortify::auth.sign-in.forgot_password')</a>
                        </div>
                    @endif

                    <button type="submit" class="w-full button-secondary md:w-auto">
                        @lang('fortify::actions.sign_in')
                    </button>
                </div>
            </div>
        </form>

        @if(Route::has('register'))
            <div class="text-center">
                <div class="pt-4 mt-4">
                    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.register-now" />
                </div>
            </div>
        @endif
    </div>
@endsection
