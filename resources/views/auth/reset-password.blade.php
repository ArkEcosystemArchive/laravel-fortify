@extends('layouts.app')

@slot('title')
    {{ trans('metatags.reset-password') ?? trans('fortify::metatags.reset-password') }}
@endslot

@section('back-bar')
    <x-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('menu.sign-in') ?? trans('fortify::menu.sign-in')],
        ['label' => trans('fortify::menu.reset-password')],
    ]" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto my-8 md:w-3/4 lg:w-3/5 xl:w-1/2">
            <h1 class="mx-4 text-2xl font-bold md:text-4xl md:mx-8 xl:mx-16">@lang('fortify::auth.reset-password.page_header')</h1>

            <div class="mt-5 lg:mt-8">
                <form
                    method="POST"
                    action="{{ route('password.update') }}"
                    class="flex flex-col p-8 mx-4 border rounded-lg border-theme-secondary-200 md:mx-0 lg:p-8 xl:mx-8"
                >
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-4">
                        <div class="flex flex-1">
                            <x-ark-input
                                type="email"
                                name="email"
                                :label="trans('fortify::forms.email')"
                                autocomplete="email"
                                class="w-full"
                                :autofocus="true"
                                :value="old('email', $request->email)"
                                :required="true"
                                :errors="$errors"
                                readonly
                            />
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex flex-1">
                            <x-ark-input
                                type="password"
                                name="password"
                                :label="trans('fortify::forms.password')"
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
                                :label="trans('fortify::forms.confirm_password')"
                                autocomplete="new-password"
                                class="w-full"
                                :required="true"
                                :errors="$errors"
                            />
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="w-full button-primary md:w-auto">
                            @lang('fortify::actions.reset_password')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
