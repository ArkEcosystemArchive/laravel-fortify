@extends('layouts.app')

@section('title')
    @lang('fortify::metatags.login')
@endsection

@section('back-bar')
    <x-breadcrumbs :crumbs="[
        ['route' => 'home', 'label' => trans('fortify::menu.home')],
        ['label' => trans('fortify::menu.sign-in')],
    ]" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto my-8 md:w-3/4 lg:w-3/5 xl:w-1/2">
            <h1 class="mx-4 text-2xl font-bold md:text-4xl md:mx-8 xl:mx-16">Sign in</h1>
            <div class="mx-4 mt-2 text-theme-secondary-700 md:mx-8 xl:mx-16">Log in to MarketSquare and connect with a growing community of like-minded blockchain enthusiasts and developers.</div>

            <div class="mt-5 lg:mt-8">
                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="flex flex-col p-8 mx-4 border rounded-lg border-theme-secondary-200 md:mx-0 lg:p-8 xl:mx-8"
                >
                    @csrf

                    @if (session('status'))
                        <x-ark-alert type="alert-success">
                            <x-slot name="message">
                                {{ session('status') }}
                            </x-slot>
                        </x-ark-alert>
                    @endif

                    <div class="mb-4">
                        <div class="flex flex-1">
                            @php
                                $username = \Laravel\Fortify\Fortify::username();
                                $altUsername = Config::get('fortify.alt_username');
                                $type = 'text';

                                if ($altUsername) {
                                    $label = __('fortify::forms.' . $username) . ' or ' . __('fortify::forms.' . $altUsername); 
                                } else {
                                    $label = __('fortify::forms.' . $username);
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
                                :required="true"
                                :errors="$errors"
                            />
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex flex-1">
                            <x-ark-input
                                type="password"
                                name="password"
                                :label="__('fortify::forms.password')"
                                autocomplete="password"
                                class="w-full"
                                :required="true"
                                :errors="$errors"
                            />
                        </div>
                    </div>

                    <div class="flex justify-between">
                        @if(Route::has('password.request'))
                            <div class="flex-1 m-auto">
                                <a href="{{ route('password.request') }}" class="link">Forgot password?</a>
                            </div>
                        @endif

                        <button type="submit" class="button-primary">
                            Sign In
                        </button>
                    </div>

                    @if(Route::has('register'))
                        <div class="text-center">
                            <div class="pt-4 mt-8 border-t border-theme-secondary-200">
                                Not a member? <a href="{{ route('register') }}" class="link">Sign up now</a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
