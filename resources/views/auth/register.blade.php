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
                <form
                    method="POST"
                    action="{{ $formUrl }}"
                    class="flex flex-col p-8 mx-4 border rounded-lg border-theme-secondary-200 md:mx-0 lg:p-8 xl:mx-8"
                >
                    @csrf

                    @if($invitation)
                        <input type="hidden" name="name" value="{{ $invitation->name }}" />
                    @else
                        <div class="mb-4">
                            <div class="flex flex-1">
                                <x-ark-input
                                    name="name"
                                    label="Name"
                                    autocomplete="name"
                                    class="w-full"
                                    :autofocus="true"
                                    :value="old('name')"
                                    :required="true"
                                    :errors="$errors"
                                />
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <div class="flex flex-1">
                            <x-ark-input
                                type="text"
                                name="username"
                                label="Username"
                                autocomplete="username"
                                class="w-full"
                                :required="true"
                                :errors="$errors"
                            />
                        </div>
                    </div>

                    @if($invitation)
                        <input type="hidden" name="email" value="{{ $invitation->email }}" />
                    @else
                        <div class="mb-4">
                            <div class="flex flex-1">
                                <x-ark-input
                                    type="email"
                                    name="email"
                                    label="Email"
                                    autocomplete="email"
                                    class="w-full"
                                    :value="old('email')"
                                    :required="true"
                                    :errors="$errors"
                                />
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <div class="flex flex-1">
                            <x-ark-input
                                type="password"
                                name="password"
                                label="Password"
                                autocomplete="new-password"
                                class="w-full"
                                :required="true"
                                :errors="$errors"
                            />
                        </div>

                        @if (! request()->session()->get('errors'))
                            <div class="text-sm text-theme-secondary-600">@lang('fortify::forms.update_password.requirements_notice')</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="flex flex-1">
                            <x-ark-input
                                type="password"
                                name="password_confirmation"
                                label="Confirm Password"
                                autocomplete="new-password"
                                class="w-full"
                                :required="true"
                                :errors="$errors"
                            />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-ark-checkbox
                            name="terms"
                            :errors="$errors"
                        >
                            @slot('label')
                                Creating an account means you're okay with our
                                <a href="{{ route('terms-of-service') }}" class="link">Terms of Service</a> and
                                <a href="{{ route('privacy-policy') }}" class="link">Privacy Policy</a>.
                            @endslot
                        </x-ark-checkbox>

                        @error('terms')
                            <p class="input-help--error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4 text-right">
                        <button type="submit" class="w-full button-primary md:w-auto">
                            Create Account
                        </button>
                    </div>

                    <div class="text-center">
                        <div class="pt-4 mt-8 border-t border-theme-secondary-200">
                            Already a member? <a href="/login" class="link">Sign in</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
