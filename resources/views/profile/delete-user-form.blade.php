<div>
    <div class="flex flex-col">
        <span class="text-2xl font-semibold text-theme-secondary-900">@lang('fortify::pages.delete_account_title')</span>
        <span>
            @lang('fortify::pages.delete_account_description')
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
        <x-ark-modal>
            <x-slot name="title">
                @lang('fortify::forms.delete-user.title')
            </x-slot>

            <x-slot name="description">
                <div class="flex flex-col mt-4">
                    <div class="flex justify-center w-full">
                        <img src="{{ asset("images/modal/delete.svg") }}" />
                    </div>
                    <span>
                        @lang('fortify::forms.delete-user.confirmation')
                    </span>
                </div>
            </x-slot>

            <x-slot name="buttons">
                <div class="flex flex-col w-full sm:flex-row justify-end mt-5 space-y-4 sm:space-y-0 sm:space-x-3">
                    <button class="button-secondary"
                        wire:click="$toggle('confirmingUserDeletion')">@lang('actions.cancel')</button>
                    <button class="inline-flex justify-center items-center button-primary" wire:click="destroy">
                        @svg('trash', 'h-4 w-4')
                        <span class="ml-2">@lang('actions.delete')</span>
                    </button>
                </div>
            </x-slot>
        </x-ark-modal>
    @endif
</div>
