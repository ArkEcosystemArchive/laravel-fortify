@extends('layouts.app')

<x-ark-metadata page="verification.notice" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' =>trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.verify')],
    ]" />
@endsection

@section('content')
    <div class="flex max-w-xl p-8 mx-auto my-6 bg-white rounded-xl">
        <div class="flex flex-col w-full text-center space-y-6">
            <div class="space-y-4">
                <h1>@lang('fortify::auth.verify.page_header')</h1>

                <p>@lang('fortify::auth.verify.link_description')</p>
            </div>

            <img class="mb-5 mx-12" src="/images/auth/verify-email.svg" />

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <p class="text-sm text-theme-secondary-600 lg:no-wrap-span-children">
                    @lang('fortify::auth.verify.resend_verification')
                </p>
            </form>
        </div>
    </div>
@endsection
