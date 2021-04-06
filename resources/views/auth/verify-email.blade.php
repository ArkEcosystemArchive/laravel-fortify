@extends('layouts.app')

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
    <div class="flex max-w-xl p-8 mx-auto my-6 bg-white rounded-lg">
        <div class="flex flex-col w-full text-center space-y-6">
            <div class="space-y-4">
                <h1>@lang('fortify::auth.verify.page_header')</h1>

                <p>@lang('fortify::auth.verify.link_description')</p>
            </div>

            <img class="mb-5 mx-12" src="/images/auth/verify-email.svg" />

            <form method="POST" action="{{ route('verification.send') }}" x-data="resend()" x-init="init()" x-ref="resend_form" @submit.prevent="disable()">
                @csrf

                <p class="text-sm text-theme-secondary-600 lg:no-wrap-span-children">
                    @lang('fortify::auth.verify.resend_verification')
                </p>
            </form>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        function resend() {
            return {
                timeout: 1000 * 60 * 5,
                form: null,
                button: null,
                tooltip: null,

                init() {
                    this.form = this.$refs.resend_form;
                    this.button = this.$refs.resend_submit;
                    this.tooltip = this.$refs.resend_tooltip;

                    this.isRunning() ? this.disable() : this.enable();
                },

                disable() {
                    this.form.disabled = true;
                    this.tooltip.classList.remove('pointer-events-none');
                    sessionStorage.setItem('verification_sent', 1);

                    setTimeout(() => this.enable(), this.timeout);
                },

                enable() {
                    this.form.disabled = false;
                    this.tooltip.classList.add('pointer-events-none');
                    sessionStorage.removeItem('verification_sent');
                },

                isRunning() {
                    return sessionStorage.getItem('verification_sent') === '1';
                }
            }
        }
    </script>
@endpush
