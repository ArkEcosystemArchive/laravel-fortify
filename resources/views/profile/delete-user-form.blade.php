<div>
    <div class="flex flex-col">
        <span class="header-4">@lang('fortify::pages.user-settings.delete_account_title')</span>
        <span class="mt-4">
            @lang('fortify::pages.user-settings.delete_account_description')
        </span>

        <div class="flex flex-row justify-end mt-8">
            <button type="submit" class="inline-flex items-center space-x-2 button-secondary"
                wire:click="confirmUserDeletion">
                @svg('trash', 'h-4 w-4')
                <span>@lang('fortify::actions.delete_account')</span>
            </button>
        </div>
    </div>

    @if($this->confirmingUserDeletion)
        <x-ark-modal title-class="header-2" width-class="max-w-xl">
            <x-slot name="title">
                @lang('fortify::forms.delete-user.title')
            </x-slot>

            <x-slot name="description">
                <div class="flex flex-col mt-4">
                    <div class="flex justify-center w-full">
                        <img class="w-2/3" src="{{ asset("images/modal/delete-account.svg") }}" />
                    </div>
                    <div class="mt-4">
                        @lang('fortify::forms.delete-user.confirmation')
                    </div>
                </div>
            </x-slot>

            <x-slot name="buttons">
                <div class="flex flex-col w-full sm:flex-row justify-end mt-5 space-y-4 sm:space-y-0 sm:space-x-3">
                    <button class="button-secondary" wire:click="$toggle('confirmingUserDeletion')">
                        @lang('fortify::actions.cancel')
                    </button>

                    <button class="inline-flex justify-center items-center button-primary" wire:click="deleteUser">
                        @svg('trash', 'h-4 w-4')
                        <span class="ml-2">@lang('fortify::actions.delete')</span>
                    </button>
                </div>
            </x-slot>
        </x-ark-modal>
    @endif
</div>
