<div>
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
                    @lang('fortify::pages.user-settings.2fa_summary')
                </div>
            </div>

            <div class="flex sm:hidden w-full mt-8 space-y-4">
                <div class="w-full">
                    <x-ark-input
                        type="number"
                        name="state.otp"
                        :label="trans('fortify::pages.user-settings.one_time_password')"
                        :errors="$errors"
                    />
                </div>
            </div>

            <hr class="flex sm:hidden my-8 border-t border-theme-primary-100">

            <div class="flex flex-col sm:flex-row items-center sm:items-start sm:mt-8">
                <div class="flex flex-col justify-center items-center border border-theme-secondary-400 rounded-md sm:mr-10">
                    <div class="py-2 px-2">
                        {!! $this->twoFactorQrCodeSvg !!}
                    </div>
                    <div class="border-t border-theme-secondary-400 w-full text-center mt-1 py-2 bg-theme-secondary-100 rounded-b-md">
                        <span class="text-theme-secondary-900">{{ $this->state['two_factor_secret'] }}</span>
                    </div>
                </div>

                <div class="hidden sm:flex h-64 w-1 bg-theme-primary-100 mr-10"></div>

                <div class="hidden sm:flex flex-col">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                        @lang('fortify::pages.user-settings.2fa_not_enabled_title')
                    </span>
                    <div class="mt-2 text-base leading-7 text-theme-secondary-600">
                        @lang('fortify::pages.user-settings.2fa_summary')
                    </div>

                    <div class="hidden md:flex w-full mt-8">
                        <div class="w-full">
                            <x-ark-input
                                type="number"
                                name="state.otp"
                                :label="trans('fortify::pages.user-settings.one_time_password')"
                                :errors="$errors"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex md:hidden w-full mt-8 space-y-4">
                <div class="w-full">
                    <x-ark-input
                        type="number"
                        name="state.otp"
                        :label="trans('fortify::pages.user-settings.one_time_password')"
                        :errors="$errors"
                    />
                </div>
            </div>

            <div class="flex sm:justify-end mt-8">
                <button
                    type="button"
                    class="button-secondary w-full sm:w-auto"
                    wire:click="enableTwoFactorAuthentication"
                >
                    @lang('fortify::actions.enable')
                </button>
            </div>
        </div>
    @else
        <div class="flex flex-col">
            <span class="header-4">@lang('fortify::pages.user-settings.2fa_title')</span>
            <span class="mt-4">@lang('fortify::pages.user-settings.2fa_description')</span>

            <div class="mt-4 sm:mt-8 flex flex-col items-center space-y-4 sm:items-start sm:flex-row sm:space-y-0 sm:space-x-6">
                <img src="{{ asset('/images/profile/2fa.svg') }}" class="w-24 h-24" alt="">
                <div class="flex flex-col">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                        @lang('fortify::pages.user-settings.2fa_enabled_title')
                    </span>
                    <div class="mt-2 text-theme-secondary-600">
                        @lang('fortify::pages.user-settings.2fa_summary')
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col space-y-3 sm:flex-row sm:justify-end sm:space-y-0 sm:space-x-3 w-full">
                <button type="button" class="button-secondary w-full sm:w-auto" wire:click="showConfirmPassword">
                    @lang('fortify::actions.recovery_codes')
                </button>

                <button type="submit" class="button-primary w-full sm:w-auto" wire:click="disableTwoFactorAuthentication">
                    @lang('fortify::actions.disable')
                </button>
            </div>
        </div>
    @endif

    @if($this->modalShown)
        <x-ark-modal title-class="header-2">
            @slot('title')
                @lang('fortify::pages.user-settings.2fa_reset_code_title')
            @endslot

            @slot('description')
                <div class="flex flex-col space-y-4 mt-8">
                    <x-ark-alert type="warning">
                        <x-slot name="message">
                            @lang('fortify::pages.user-settings.2fa_warning_text')
                        </x-slot>
                    </x-ark-alert>
                    <div class="grid grid-cols-1 sm:grid-cols-2 grid-flow-row gap-x-4 gap-y-4">
                        @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                            <div class="flex border border-theme-secondary-300 rounded font-medium text-theme-secondary-900 h-12 items-center">
                                <span class="flex bg-theme-secondary-100 h-full w-8 justify-center items-center rounded-l">
                                    {{ $loop->index + 1 }}
                                </span>
                                <input
                                    type="text"
                                    id="resetCode_{{ $loop->index }}"
                                    class="ml-4 w-full"
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
                <div class="flex flex-col-reverse sm:flex-row w-full sm:justify-between">
                    <div class="flex justify-center sm:justify-start w-full mt-3 sm:mt-0">
                        <x-ark-file-download
                            :filename="'2fa_recovery_code_' . $this->user->name"
                            :content="implode('\n', json_decode(decrypt($this->user->two_factor_recovery_codes)))"
                            :title="trans('fortify::actions.download')"
                            wrapper-class="w-full sm:w-auto"
                            class="w-full justify-center"
                        />
                    </div>
                    <div class="flex justify-center">
                        <button class="button-primary items-center w-full sm:w-auto whitespace-nowrap" wire:click="hideRecoveryCodes">
                            @lang('fortify::actions.understand')
                        </button>
                    </div>
                </div>
            @endslot
        </x-ark-modal>
    @endif

    @if($this->confirmPasswordShown)
        <x-ark-modal title-class="header-2" width-class="max-w-2xl" wire-close="closeConfirmPassword">
            <x-slot name="title">
                @lang('fortify::forms.confirm-password.title')
            </x-slot>

            <x-slot name="description">
                <div class="flex flex-col mt-4">
                    <div class="flex justify-center w-full mt-8">
                        <img src="{{ asset('/images/auth/confirm-password.svg') }}" class="w-auto h-auto" alt="">
                    </div>
                    <div class="mt-8">
                        @lang('fortify::forms.confirm-password.description')
                    </div>
                </div>
                <form class="mt-8">
                    <div class="space-y-2">
                        <x-ark-input type="password" name="password" model="confirmedPassword" :label="trans('fortify::forms.password')" />
                    </div>
                </form>
            </x-slot>

            <x-slot name="buttons">
                <div class="flex flex-col-reverse w-full sm:flex-row justify-end space-y-4 space-y-reverse sm:space-y-0 sm:space-x-3">
                    <button type="button" dusk="confirm-password-form-cancel" class="button-secondary" wire:click="closeConfirmPassword">
                        @lang('fortify::actions.cancel')
                    </button>

                    <button type="submit" dusk="confirm-password-form-submit" class="inline-flex justify-center items-center button-primary" wire:click="showRecoveryCodesAfterPasswordConfirmation" {{ ! $this->hasConfirmedPassword() ? 'disabled' : ''}}>
                        <span>@lang('fortify::actions.confirm')</span>
                    </button>
                </div>
            </x-slot>
        </x-ark-modal>
    @endif
</div>
