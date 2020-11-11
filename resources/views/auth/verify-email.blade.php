@extends('layouts.app')

@section('title')
    <x-data-bag key="fortify-content" resolver="path" view="page-title" />
@endsection

@section('breadcrumbs')
    <x-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' =>trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.verify')],
    ]" />
@endsection

@section('content')
    <div class="flex max-w-md p-8 mx-auto my-6 bg-white rounded-lg">
        <div class="flex flex-col w-full">
            <img class="mb-5" src="/images/verify-email.svg" />
            <h2>@lang('fortify::auth.verify.page_header')</h2>
            <p>
                @lang('fortify::auth.verify.link_description')
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <p class="mt-5 text-sm text-theme-secondary-600">
                    @lang('fortify::auth.verify.resend_verification')
                </p>
            </form>
        </div>
    </div>
@endsection
