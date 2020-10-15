<div>
    <div class="flex flex-col">
        <span class="text-2xl font-semibold text-theme-secondary-900">@lang('fortify::pages.user-settings.contact_information_title')</span>
        <span>@lang('fortify::pages.user-settings.contact_information_description')</span>

        <form class="mt-8" wire:submit.prevent="updateProfileInformation">
            <div class="space-y-4">
                <x-ark-input type="text" name="name" model="state.name" :label="trans('fortify::forms.name')" :errors="$errors" />
                <x-ark-input type="email" name="email" model="state.email" :label="trans('fortify::forms.email_address')" :errors="$errors" />
            </div>
            <div class="flex justify-end mt-8">
                <button type="submit" class="button-secondary">@lang('fortify::actions.update')</button>
            </div>
        </form>
    </div>
</div>
