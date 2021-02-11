<form class="p-8 py-8 mt-8 w-full rounded-lg border border-theme-secondary-300 md:max-w-2xl" wire:submit.prevent="submit">
    @csrf
    <div class="space-y-6">
        <x-ark-select name="subject" :label="trans('fortify::forms.feedback.subject.label')" wire.model="subject" :errors="$errors">
            <option value="">@lang('fortify::forms.feedback.subject.placeholder')</option>
            {{-- @TODO fill in reasons --}}
            {{-- <option value="reason1">@lang('fortify::forms.feedback.subject.options.reason1')</option> --}}
            {{-- <option value="reason2">@lang('fortify::forms.feedback.subject.options.reason2')</option> --}}
            {{-- <option value="reason3">@lang('fortify::forms.feedback.subject.options.reason3')</option> --}}
        </x-ark-select>

        <x-ark-textarea name="message" :label="trans('fortify::forms.feedback.message.label')" wire:model="message" :errors="$errors" :placeholder="trans('fortify::forms.feedback.message.placeholder')" rows="4" />
    </div>
    <div class="flex flex-col mt-8 space-y-5 sm:flex-row-reverse sm:items-center sm:justify-between sm:space-y-0">
        <button type="submit" class="w-full sm:w-auto button-secondary">@lang('fortify::actions.send')</button>
        <a class="w-full font-semibold sm:w-auto link" href="{{ route('home') }}">@lang('fortify::actions.skip')</a>
    </div>
</form>
