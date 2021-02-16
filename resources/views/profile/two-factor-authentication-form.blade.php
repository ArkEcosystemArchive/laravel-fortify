<div>
    @if (! $this->enabled)
        <div class="flex flex-col w-full space-y-8">
            <div class="flex flex-col">
                <span class="text-lg font-bold leading-7 text-theme-secondary-900 md:header-4">
                    @lang('fortify::pages.user-settings.2fa_title')
                </span>
                <span class="mt-4">
                    @lang('fortify::pages.user-settings.2fa_description')
                </span>
            </div>

            <div class="flex flex-col sm:hidden">
                <span class="text-lg font-bold leading-7 text-theme-secondary-900">
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

                <div class="flex h-64 w-1 bg-theme-primary-100 mr-10"></div>

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

            <div class="flex mt-8">
                <div class="flex flex-col">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                        @lang('fortify::pages.user-settings.2fa_enabled_title')
                    </span>
                    <div class="mt-2 text-theme-secondary-600">
                        @lang('fortify::pages.user-settings.2fa_summary')
                    </div>
                </div>
            </div>

            <div class="flex sm:justify-end mt-8 space-x-3 w-full">
                <button type="submit" class="button-primary w-full sm:w-auto" wire:click="disableTwoFactorAuthentication">
                    @lang('fortify::actions.disable')
                </button>
            </div>
        </div>
    @endif

    @if($this->modalShown)
        <x-ark-modal class="mb-20" title-class="header-2">
            @slot('title')
                @lang('fortify::pages.user-settings.2fa_reset_code_title')
            @endslot

            @slot('description')
                <div class="flex flex-col space-y-2">
                    <x-ark-alert type="alert-warning">
                        <x-slot name="message">
                            @lang('fortify::pages.user-settings.2fa_warning_text')
                        </x-slot>
                    </x-ark-alert>
                    <div class="grid grid-cols-2 grid-flow-row gap-4">
                        @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div class="input-group">
                            <div class="input-wrapper">
                                <input
                                    type="text"
                                    id="resetCode_{{ $loop->index }}"
                                    class="input-text"
                                    value="{{ $code }}"
                                    readonly
                                />
                            </div>
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
                <div class="flex justify-center">
                    <button class="button-secondary" wire:click="hideRecoveryCodes">@lang('fortify::actions.understand')</button>
                </div>
            @endslot
        </x-ark-modal>
    @endif

    {{-- TODO: check if we allow users to show their recovery codes / generate new ones again --}}
    {{-- <div class="mt-5">
        @if (! $this->enabled)
            <form class="space-y-8" wire:submit.prevent="enableTwoFactorAuthentication">
                <x-ark-input type="number" name="state.otp" model="state.otp" :errors="$errors" :label="trans('fortify::pages.user-settings.one_time_password')" />

                <button type="submit" class="button-secondary" wire:loading.attr="disabled">@lang('fortify::actions.enable')</button>
            </form>
        @else
            @if ($showingRecoveryCodes)
                <button class="mr-3" wire:click="regenerateRecoveryCodes">
                    {{ trans('Regenerate Recovery Codes') }}
                </button>
            @else
                <button class="mr-3" wire:click="showRecoveryCodes">
                    {{ trans('Show Recovery Codes') }}
                </button>
            @endif

        @endif
    </div> --}}
</div>
