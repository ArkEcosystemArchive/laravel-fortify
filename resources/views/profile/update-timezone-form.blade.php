<div>
    <div class="flex flex-col px-8 lg:p-8 xl:mx-8">
        <span class="text-2xl font-semibold text-theme-secondary-900">@lang('fortify::pages.user-settings.update_timezone_title')</span>
        <span>@lang('fortify::pages.user-settings.update_timezone_description')</span>
        <div>
            <x-ark-flash />
        </div>

        <div class="relative mt-8 space-y-4">
            <x-ark-select :label="trans('fortify::actions.select_timezone')" :errors="$errors" name="timezone">
                @foreach ($this->timezones as $timezone)
                    @if ($timezone['timezone'] === $this->currentTimezone)
                        <option value="{{ $timezone['timezone'] }}" selected>{{ $timezone['formattedTimezone'] }}</option>
                    @else
                        <option value="{{ $timezone['timezone'] }}">{{ $timezone['formattedTimezone'] }}</option>
                    @endif
                @endforeach
            </x-ark-select>
        </div>
        <div class="flex justify-end mt-8">
            <button type="submit" class="button-secondary" wire:click="updateTimezone">@lang('fortify::actions.update')</button>
        </div>
    </div>
</div>
