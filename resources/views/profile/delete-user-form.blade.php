<div>
    <div class="flex flex-col">
        <span class="header-4">@lang('fortify::pages.user-settings.delete_account_title')</span>
        <span class="mt-4">
            @lang('fortify::pages.user-settings.delete_account_description')
        </span>

        <div class="flex flex-row justify-end mt-8">
            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center space-x-2 button-cancel"
                wire:click="confirmUserDeletion">
                @svg('trash', 'h-4 w-4')
                <span>@lang('fortify::actions.delete_account')</span>
            </button>
        </div>
    </div>

    @if($this->modalShown)
        <x-ark-modal title-class="header-2" width-class="max-w-xl" wire-close="closeModal">
            <x-slot name="title">
                @lang('fortify::forms.delete-user.title')
            </x-slot>

            <x-slot name="description">
                <div class="flex flex-col mt-4">
                    <div class="flex justify-center w-full">
                        @svg('fortify-modal.delete-account', 'text-theme-primary-600 w-2/3')
                    </div>
                    <div class="mt-4">
                        @lang('fortify::forms.delete-user.confirmation')
                    </div>
                </div>
                <form class="mt-8">
                    <div class="space-y-2">
                        <x-ark-input input-class="text-center" type="text" name="username" model="username" :label="trans('fortify::forms.confirm_username')" readonly />
                        <x-ark-input type="text" name="username_confirmation" model="usernameConfirmation" :palceholder="trans('fortify::forms.delete-user.confirmation_placeholder')" :errors="$errors" hide-label />
                    </div>
                </form>
            </x-slot>

            <x-slot name="buttons">
                <div class="flex flex-col w-full sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-3">
                    <button class="button-secondary" wire:click="closeModal">
                        @lang('fortify::actions.cancel')
                    </button>

                    <button class="inline-flex justify-center items-center button-cancel" wire:click="deleteUser" {{ ! $this->hasConfirmedName() ? 'disabled' : ''}}>
                        @svg('trash', 'h-4 w-4')
                        <span class="ml-2">@lang('fortify::actions.delete')</span>
                    </button>
                </div>
            </x-slot>
        </x-ark-modal>
    @endif
</div>
