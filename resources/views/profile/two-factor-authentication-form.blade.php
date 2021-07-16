@php
    use \Illuminate\View\ComponentAttributeBag;

    $twoAuthLink1 = view('ark::external-link-confirm', [
        'attributes' => new ComponentAttributeBag([]),
        'text' => 'Authy',
        'url' => 'https://authy.com',
    ])->render();

    $twoAuthLink2 = view('ark::external-link-confirm', [
        'attributes' => new ComponentAttributeBag([]),
        'text' => 'Google Authenticator',
        'url' => 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2',
    ])->render();
@endphp

<div dusk="two-factor-authentication-form">
    @if (! $this->enabled)
        <div class="flex flex-col w-full space-y-8">
            <div class="flex flex-col">
                <span class="header-4">
                    @lang('fortify::pages.user-settings.2fa_title')
                </span>
                <span class="mt-4">
                    @lang('fortify::pages.user-settings.2fa_description')
                </span>
            </div>

            <div class="flex flex-col sm:hidden">
                <span class="header-4">
                    @lang('fortify::pages.user-settings.2fa_not_enabled_title')
                </span>
                <div class="mt-2 text-base leading-7 text-theme-secondary-600">
                    @lang('fortify::pages.user-settings.2fa_summary', [
                        'link1' => $twoAuthLink1,
                        'link2' => $twoAuthLink2,
                    ])
                </div>
            </div>

            <div class="flex w-full mt-8 space-y-4 sm:hidden">
                <div class="w-full">
                    <x-ark-input
                        type="number"
                        name="state.otp"
                        :label="trans('fortify::pages.user-settings.one_time_password')"
                        :errors="$errors"
                        pattern="[0-9]{6}"
                        class="hide-number-input-arrows"
                    />
                </div>
            </div>

            <hr class="flex my-8 border-t sm:hidden border-theme-primary-100">

            <div class="flex flex-col items-center sm:flex-row sm:items-start sm:mt-8">
                <div class="flex flex-col items-center justify-center border rounded-xl border-theme-secondary-400 sm:mr-10">
                    <div class="px-2 py-2">
                        {!! $this->twoFactorQrCodeSvg !!}
                    </div>
                    <div class="w-full py-2 mt-1 text-center border-t border-theme-secondary-400 bg-theme-secondary-100 rounded-b-xl">
                        <span class="text-theme-secondary-900">{{ $this->state['two_factor_secret'] }}</span>
                    </div>
                </div>

                <div class="hidden w-1 h-64 mr-10 sm:flex bg-theme-primary-100"></div>

                <div class="flex-col hidden sm:flex">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                        @lang('fortify::pages.user-settings.2fa_not_enabled_title')
                    </span>


                    <div class="mt-2 text-base leading-7 text-theme-secondary-600">
                        @lang('fortify::pages.user-settings.2fa_summary', [
                            'link1' => $twoAuthLink1,
                            'link2' => $twoAuthLink2,
                        ])
                    </div>

                    <div class="hidden w-full mt-8 md:flex">
                        <div class="w-full">
                            <x-ark-input
                                type="number"
                                name="state.otp"
                                :label="trans('fortify::pages.user-settings.one_time_password')"
                                :errors="$errors"
                                pattern="[0-9]{6}"
                                class="hide-number-input-arrows"
                                dusk="one-time-password"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden w-full mt-8 space-y-4 sm:flex md:hidden">
                <div class="w-full">
                    <x-ark-input
                        type="number"
                        name="state.otp"
                        :label="trans('fortify::pages.user-settings.one_time_password')"
                        :errors="$errors"
                        pattern="[0-9]{6}"
                        class="hide-number-input-arrows"
                    />
                </div>
            </div>

            <div class="flex mt-8 sm:justify-end">
                <button
                    type="button"
                    class="w-full button-secondary sm:w-auto"
                    wire:click="enableTwoFactorAuthentication"
                    dusk="enable-two-factor-authentication"
                >
                    @lang('fortify::actions.enable')
                </button>
            </div>
        </div>
    @else
        <div class="flex flex-col">
            <span class="header-4">@lang('fortify::pages.user-settings.2fa_title')</span>
            <span class="mt-4">@lang('fortify::pages.user-settings.2fa_description')</span>

            <div class="flex flex-col items-center mt-4 space-y-4 sm:mt-8 sm:items-start sm:flex-row sm:space-y-0 sm:space-x-6">
                <img src="{{ asset('/images/profile/2fa.svg') }}" class="w-24 h-24" alt="">
                <div class="flex flex-col">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                        @lang('fortify::pages.user-settings.2fa_enabled_title')
                    </span>
                    <div class="mt-2 text-theme-secondary-600">

                        @lang('fortify::pages.user-settings.2fa_summary', [
                            'link1' => $twoAuthLink1,
                            'link2' => $twoAuthLink2,
                        ])
                    </div>
                </div>
            </div>

            <div class="flex flex-col w-full mt-8 space-y-3 sm:flex-row sm:justify-end sm:space-y-0 sm:space-x-3">
                <button type="button" class="w-full button-secondary sm:w-auto" wire:click="showRecoveryCodesConfirmationModal">
                    @lang('fortify::actions.recovery_codes')
                </button>

                <button
                    type="submit"
                    class="w-full button-primary sm:w-auto"
                    wire:click="showDisable2FAModal"
                    dusk="disable-two-factor-authentication"
                >
                    @lang('fortify::actions.disable')
                </button>
            </div>
        </div>
    @endif

    <div dusk="recovery-codes-modal">
        @if($this->modalShown)
            <x-ark-modal title-class="header-2">
                @slot('title')
                    @lang('fortify::pages.user-settings.2fa_reset_code_title')
                @endslot

                @slot('description')
                    <div class="flex flex-col mt-8 space-y-4">
                        <x-ark-alert type="warning">
                            <x-slot name="message">
                                @lang('fortify::pages.user-settings.2fa_warning_text')
                            </x-slot>
                        </x-ark-alert>
                        <div class="grid grid-flow-row grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                            @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                                <div class="flex items-center h-12 font-medium border rounded border-theme-secondary-300 text-theme-secondary-900">
                                    <span class="flex items-center justify-center w-8 h-full rounded-l bg-theme-secondary-100">
                                        {{ $loop->index + 1 }}
                                    </span>
                                    <input
                                        type="text"
                                        id="resetCode_{{ $loop->index }}"
                                        class="w-full ml-4"
                                        value="{{ $code }}"
                                        readonly
                                    />
                                </div>
                            @endforeach
                            {{-- TODO: check if we need this or not --}}
                            {{-- <div class="mt-6">
                                <x-ark-clipboard :value="$this->resetCode"/>
                            </div> --}}
                        </div>
                    </div>
                @endslot

                @slot('buttons')
                    <div class="flex flex-col-reverse w-full sm:flex-row sm:justify-between">
                        <div class="flex justify-center w-full mt-3 sm:justify-start sm:mt-0">
                            <x-ark-file-download
                                :filename="'2fa_recovery_code_' . $this->user->name"
                                :content="implode('\n', json_decode(decrypt($this->user->two_factor_recovery_codes)))"
                                :title="trans('fortify::actions.download')"
                                wrapper-class="w-full sm:w-auto"
                                class="justify-center w-full"
                            />
                        </div>
                        <div class="flex justify-center">
                            <button class="items-center w-full button-primary sm:w-auto whitespace-nowrap" wire:click="hideRecoveryCodes" dusk="recovery-codes-understand">
                                @lang('fortify::actions.understand')
                            </button>
                        </div>
                    </div>
                @endslot
            </x-ark-modal>
        @endif
    </div>

    <x-ark-fortify::confirm-password-modal />
</div>
