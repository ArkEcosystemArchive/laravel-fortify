@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="two-factor.login" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.2fa')],
    ]" />
@endsection

@section('content')
    <div class="w-full py-8 bg-theme-secondary-100">
        <div class="container mx-auto ">
            <h1 class="mx-4 text-2xl font-bold text-center md:text-4xl md:mx-8 xl:mx-16 text-theme-secondary-900">@lang('fortify::auth.two-factor.page_header')</h1>
            <p class="mx-4 mt-4 font-semibold text-center text-theme-secondary-700 md:mx-8 xl:mx-16">@lang('fortify::auth.two-factor.page_description')</p>
        </div>
    </div>

    <div
        x-data="{ recovery: @json($errors->has('recovery_code')) }"
        x-cloak
        class="max-w-xl p-8 mx-auto"
    >
        <form
            x-show="!recovery"
            method="POST"
            action="{{ route('two-factor.login') }}"
            class="flex flex-col py-8 px-4 sm:px-8 mx-4 border-2 rounded-lg border-theme-secondary-200"
        >
            @csrf

            <div class="mb-8">
                <div class="flex flex-1">
                    <x-ark-input
                        type="text"
                        name="code"
                        :label="trans('fortify::forms.2fa_code')"
                        class="w-full"
                        :errors="$errors"
                        autocomplete="one-time-code"
                        input-mode="numeric"
                        pattern="[0-9]*"
                    />
                </div>
            </div>

            <div class="flex flex-col-reverse items-center justify-between sm:flex-row">
                <button @click="recovery = true" type="button" class="w-full mt-4 font-semibold link sm:w-auto sm:mt-0">
                    @lang('fortify::actions.enter_recovery_code')
                </button>

                <button type="submit" class="w-full button-secondary sm:w-auto">
                    @lang('fortify::actions.sign_in')
                </button>
            </div>
        </form>

        <form
            x-show="recovery"
            method="POST"
            action="{{ route('two-factor.login') }}"
            class="flex flex-col p-8 mx-4 border-2 rounded-lg border-theme-secondary-200"
        >
            @csrf

            <div class="mb-8" >
                <div class="flex flex-1">
                    <x-ark-input
                        type="password"
                        name="recovery_code"
                        :label="trans('fortify::forms.recovery_code')"
                        class="w-full"
                        :errors="$errors"
                    />
                </div>
            </div>

            <div class="flex flex-col-reverse items-center justify-between sm:flex-row">
                <button @click="recovery = false" type="button" class="w-full mt-4 font-semibold link sm:w-auto sm:mt-0" x-cloak>
                    @lang('fortify::actions.enter_2fa_code')
                </button>

                <button type="submit" class="w-full button-secondary sm:w-auto">
                    @lang('fortify::actions.sign_in')
                </button>
            </div>
        </form>
    </div>

@endsection
