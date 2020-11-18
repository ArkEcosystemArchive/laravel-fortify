<div>
    @if (! $this->enabled)
        <div class="flex flex-col">
            <span class="text-2xl font-semibold leading-9 text-theme-secondary-900">@lang('fortify::pages.user-settings.2fa_title')</span>
            <span class="paragraph-description">@lang('fortify::pages.user-settings.2fa_description')</span>

            <div class="flex justify-start mt-8">
                <div class="flex md:divide-x md:divide-theme-secondary-400">
                    <div class="hidden md:flex flex-col justify-center items-center border border-theme-secondary-400 mr-10">
                        <div class="py-2 px-2">
                            {!! $this->twoFactorQrCodeSvg !!}
                        </div>
                        <div class="border-t border-theme-secondary-400 w-full text-center mt-1 py-2 bg-theme-secondary-100">
                            <span class="two-fa-secret text-theme-secondary-900">{{ $this->state['two_factor_secret'] }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col justify-between sm:pl-10">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold leading-7 text-theme-secondary-900">@lang('fortify::pages.user-settings.2fa_not_enabled_title')</span>

                            <div class="mt-2 text-base leading-7 text-theme-secondary-600">
                                @lang('fortify::pages.user-settings.2fa_summary')
                            </div>
                        </div>
                        <div class="flex flex-col items-start mt-4 md:hidden">
                            <div class="flex flex-col justify-center items-center border border-theme-secondary-400 mr-10">
                                <div class="py-2 px-2">
                                    {!! $this->twoFactorQrCodeSvg !!}
                                </div>
                                <div class="border-t border-theme-secondary-400 w-full text-center mt-1 py-2 bg-theme-secondary-100">
                                    <span class="two-fa-secret text-theme-secondary-900">{{ $this->state['two_factor_secret'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 space-y-4">
                            <x-ark-input type="number" name="state.otp" :label="trans('fortify::pages.user-settings.one_time_password')" :errors="$errors" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <button type="button" class="button-secondary" wire:click="enableTwoFactorAuthentication">@lang('fortify::actions.enable')</button>
            </div>
        </div>
    @else
        <div class="flex flex-col">
            <span class="text-2xl font-semibold text-theme-secondary-900">@lang('fortify::pages.user-settings.2fa_title')</span>
            <span>@lang('fortify::pages.user-settings.2fa_description')</span>

            <div class="flex mt-3">
                <div class="flex flex-col">
                    <strong>@lang('fortify::pages.user-settings.2fa_enabled_title')</strong>
                    <div class="mt-2 text-sm text-theme-secondary-600">
                        @lang('fortify::pages.user-settings.2fa_summary')
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-8 space-x-3">
                <button type="submit" class="button-primary" wire:click="disableTwoFactorAuthentication">@lang('fortify::actions.disable')</button>
            </div>
        </div>
    @endif

    @if($showingRecoveryCodes)
        <x-ark-modal>
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
