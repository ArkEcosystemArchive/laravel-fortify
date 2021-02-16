<form class="p-8 py-8 mt-8 w-full rounded-lg border border-theme-secondary-300 md:max-w-2xl" wire:submit.prevent="submit">
    @csrf
    <x-ark-textarea name="message" :label="trans('fortify::forms.feedback.message.label')" wire:model="message" :errors="$errors" :placeholder="trans('fortify::forms.feedback.message.placeholder')" rows="4" />
    <div class="flex flex-col mt-8 space-y-5 sm:flex-row-reverse sm:items-center sm:justify-between sm:space-y-0">
        <button type="submit" class="w-full sm:w-auto button-secondary">@lang('fortify::actions.send')</button>
        <a class="w-full font-semibold sm:w-auto link" href="{{ route('home') }}">@lang('fortify::actions.skip')</a>
    </div>
</form>
