<div>
    <div class="flex flex-col">
        <span class="text-2xl font-semibold text-theme-secondary-900">@lang('fortify::pages.user-settings.gdpr_title')</span>
        <span>@lang('fortify::pages.user-settings.gdpr_description')</span>

        <div class="flex justify-end mt-8">
            <button type="submit" class="button-secondary" wire:click="export">@lang('fortify::actions.export_personal_data')</button>
        </div>
    </div>
</div>
