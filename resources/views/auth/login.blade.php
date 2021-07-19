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
            class="flex flex-col px-4 py-8 mx-4 border-2 rounded-xl sm:px-8 border-theme-secondary-200"
        >
            @csrf

            <div class="flex flex-col space-y-5">
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
                    <x-ark-password-toggle
                        name="password"
                        :label="trans('fortify::forms.password')"
                        autocomplete="password"
                        class="w-full"
                        :errors="$errors"
                    />
                </div>

                <x-ark-checkbox name="remember" :errors="$errors">
                    @slot('label')
                        @lang('fortify::auth.sign-in.remember_me')
                    @endslot
                </x-ark-checkbox>

                @php($hasForgotPassword = Route::has('password.request'))

                <div class="flex flex-col-reverse items-center space-y-4 sm:space-y-0 sm:flex-row {{ $hasForgotPassword ? 'justify-between' : 'justify-end' }}">
                    <div>
                    @if($hasForgotPassword)
                        <div class="flex-1 mt-8 sm:mt-0">
                            <a href="{{ route('password.request') }}" class="link font-semibold">@lang('fortify::auth.sign-in.forgot_password')</a>
                        </div>
                    @endif
                    </div>

                    <button type="submit" class="w-full button-secondary sm:w-auto">
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
