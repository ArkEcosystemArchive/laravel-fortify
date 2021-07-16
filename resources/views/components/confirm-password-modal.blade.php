@if($this->confirmPasswordShown)
    <x-ark-modal title-class="header-2" width-class="max-w-2xl" wire-close="cancelConfirmPassword">
        <x-slot name="title">
            {{ $this->confirmPasswordTitle }}
        </x-slot>

        <x-slot name="description">
            <div class="flex flex-col mt-4">
                <div class="flex justify-center w-full mt-8">
                    <img src="{{ asset('/images/auth/confirm-password.svg') }}" class="w-auto h-auto" alt="">
                </div>
                <div class="mt-8">
                    {{ $this->confirmPasswordDescription }}
                </div>
            </div>
            <form class="mt-8">
                <div class="space-y-2">
                    <input type="hidden" autocomplete="email" />

                    <x-ark-password-toggle
                        name="password"
                        model="confirmedPassword"
                        :label="trans('fortify::forms.password')"
                        autocomplete="current-password"
                    />
                </div>
            </form>
        </x-slot>

        <x-slot name="buttons">
            <div class="flex flex-col-reverse justify-end w-full space-y-4 space-y-reverse sm:flex-row sm:space-y-0 sm:space-x-3">
                <button type="button" dusk="confirm-password-form-cancel" class="button-secondary" wire:click="cancelConfirmPassword">
                    @lang('fortify::actions.cancel')
                </button>

                <button type="submit" dusk="confirm-password-form-submit" class="inline-flex items-center justify-center button-primary" wire:click="submitConfirmPassword" {{ ! $this->hasConfirmedPassword() ? 'disabled' : ''}}>
                    <span>@lang('fortify::actions.confirm')</span>
                </button>
            </div>
        </x-slot>
    </x-ark-modal>
@endif
