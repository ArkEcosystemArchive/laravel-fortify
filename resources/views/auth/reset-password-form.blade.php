<form
    method="POST"
    action="{{ route('password.update') }}"
    class="flex flex-col px-4 py-8 mx-4 border-2 rounded-xl sm:px-8 border-theme-secondary-200"
    x-data="{ isTyping: false }"
>
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="space-y-5">

        <div>
            <div class="flex flex-1">
                <x-ark-input
                    wire:model.defer="state.email"
                    no-model
                    type="email"
                    name="email"
                    :label="trans('fortify::forms.email')"
                    autocomplete="email"
                    class="w-full"
                    :autofocus="true"
                    :required="true"
                    :errors="$errors"
                    readonly
                />
            </div>
        </div>

        <x:ark-fortify::password-rules :password-rules="$passwordRules" rules-wrapper-class="grid gap-4 my-4 sm:grid-cols-2">
            <x-ark-password-toggle
                model="state.password"
                name="password"
                :label="trans('fortify::forms.password')"
                autocomplete="new-password"
                class="w-full"
                required="true"
                @keydown="isTyping=true"
                :errors="$errors"

            />
        </x:ark-fortify::password-rules>

        <div>
            <div class="flex flex-1">
                <x-ark-password-toggle
                    model="state.password_confirmation"
                    name="password_confirmation"
                    :label="trans('fortify::forms.confirm_password')"
                    autocomplete="new-password"
                    class="w-full"
                    :required="true"
                    :errors="$errors"
                />
            </div>
        </div>

        <div class="flex flex-col-reverse items-center justify-between space-y-4 md:space-y-0 md:flex-row">
            <div class="flex-1 mt-8 md:mt-0">
                <a href="{{ route('login') }}" class="link">@lang('fortify::actions.cancel')</a>
            </div>

            <button type="submit" class="w-full button-secondary md:w-auto">
                @lang('fortify::actions.reset_password')
            </button>
        </div>
    </div>
</form>
