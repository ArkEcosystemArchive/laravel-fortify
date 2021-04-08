<div x-data="{isTyping: false}" dusk="update-password-form" @updated-password.window="isTyping = false">
    <div class="flex flex-col space-y-4 mt-4">
        <div>
            <x-ark-flash />
        </div>

        <span class="header-4">
            @lang('fortify::pages.user-settings.password_information_title')
        </span>

        <span>
            @lang('fortify::forms.update-password.requirements_notice')
        </span>
    </div>

    <form class="mt-8" wire:submit.prevent="updatePassword">
        <div class="space-y-4">
            <x-ark-input
                type="password"
                name="current_password"
                model="state.current_password"
                :label="trans('fortify::forms.current_password')"
                :errors="$errors"
                class="w-full"
            />

            <x:ark-fortify::password-rules
                class="w-full"
                :password-rules="$passwordRules"
                is-typing="isTyping"
                rules-wrapper-class="grid gap-4 my-4 sm:grid-cols-2 lg:grid-cols-3"
            >
                <x-ark-input
                    type="password"
                    name="password"
                    model="state.password"
                    class="w-full"
                    :label="trans('fortify::forms.new_password')"
                    :errors="$errors"
                    @keydown="isTyping=true"
                />
            </x:ark-fortify::password-rules>

            <x-ark-input
                type="password"
                name="password_confirmation"
                model="state.password_confirmation"
                :label="trans('fortify::forms.confirm_password')"
                :errors="$errors"
            />
        </div>

        <div class="flex w-full mt-8 sm:justify-end">
            <button
                dusk="update-password-form-submit"
                type="submit"
                class="w-full button-secondary sm:w-auto"
            >
                @lang('fortify::actions.update')
            </button>
        </div>
    </form>
</div>
