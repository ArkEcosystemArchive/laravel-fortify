<div>
    <div class="flex flex-col">
        <span class="header-4">@lang('fortify::pages.user-settings.gdpr_title')</span>
        <span class="mt-4">@lang('fortify::pages.user-settings.gdpr_description')</span>

        <div class="flex justify-end mt-8">
            <button type="submit" class="button-secondary w-full sm:w-auto" wire:click="export">@lang('fortify::actions.export_personal_data')</button>
        </div>
    </div>
</div>
