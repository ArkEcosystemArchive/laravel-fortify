@extends('layouts.app')

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.password_reset_email')],
    ]" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="mx-auto my-8 md:w-3/4 lg:w-3/5 xl:w-1/2">
            <h1 class="mx-4 text-2xl font-bold md:text-4xl md:mx-8 xl:mx-16">@lang('fortify::auth.forgot-password.page_header')</h1>

            <div class="px-8">
                <x-ark-flash />
            </div>

            <div class="mt-5 lg:mt-8">
                <form
                    method="POST"
                    action="{{ route('password.email') }}"
                    class="flex flex-col p-8 mx-4 border rounded-lg border-theme-secondary-200 md:mx-0 lg:p-8 xl:mx-8"
                >
                    @csrf

                    <div class="mb-4">
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

                    <div class="text-right">
                        <button type="submit" class="w-full button-primary md:w-auto">
                            @lang('fortify::auth.forgot-password.reset_link')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
