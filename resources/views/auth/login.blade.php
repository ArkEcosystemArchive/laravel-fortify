@extends('layouts.app')

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-breadcrumbs :crumbs="[
        ['route' => 'home', 'label' => trans('fortify::menu.home')],
        ['label' => trans('fortify::menu.sign_in')],
    ]" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto my-8 md:w-3/4 lg:w-3/5 xl:w-1/2">
            <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.component-heading" />

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

                    <div class="mb-8">
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
                                :required="true"
                                :errors="$errors"
                            />
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex flex-1">
                            <x-ark-input
                                type="password"
                                name="password"
                                :label="trans('fortify::forms.password')"
                                autocomplete="password"
                                class="w-full"
                                :required="true"
                                :errors="$errors"
                            />
                        </div>
                    </div>

                    <div class="flex flex-col-reverse space-y-4 sm:space-y-0 sm:flex-row items-center justify-between">
                        @if(Route::has('password.request'))
                            <div class="flex-1 mt-8 sm:mt-0">
                                <a href="{{ route('password.request') }}" class="link">@lang('fortify::auth.sign-in.forgot_password')</a>
                            </div>
                        @endif

                        <button type="submit" class="w-full button-secondary md:w-auto">
                            @lang('fortify::actions.sign_in')
                        </button>
                    </div>
                </form>

                @if(Route::has('register'))
                    <div class="text-center">
                        <div class="pt-4 mt-4">
                            @lang('fortify::auth.sign-in.register_now', ['route' => route('register')])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
