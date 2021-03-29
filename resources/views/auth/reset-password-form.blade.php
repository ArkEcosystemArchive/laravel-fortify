<form
    method="POST"
    action="{{ route('password.update') }}"
    class="flex flex-col p-8 mx-4 border rounded-lg border-theme-secondary-200 md:mx-0 lg:p-8 xl:mx-8"
    x-data="{ isTyping: false }"
>
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-8">
        <div class="flex flex-1">
            <x-ark-input
                wire:model.defer="state.email"
                no-model
                type="email"
                name="email"
                :label="trans('fortify::forms.email')"
                autocomplete="email"
                autocapitalize="none"
                class="w-full"
                :autofocus="true"
                :required="true"
                :errors="$errors"
                readonly
            />
        </div>
    </div>

    <x:ark-fortify::password-rules class="mb-8" :password-rules="$passwordRules">
        <x-ark-input
            model="state.password"
            type="password"
            name="password"
            :label="trans('fortify::forms.password')"
            autocomplete="new-password"
            class="w-full mb-2"
            required="true"
            @keydown="isTyping=true"
            :errors="$errors"
        />
    </x:ark-fortify::password-rules>

    <div class="mb-8">
        <div class="flex flex-1">
            <x-ark-input
                model="state.password_confirmation"
                type="password"
                name="password_confirmation"
                :label="trans('fortify::forms.confirm_password')"
                autocomplete="new-password"
                class="w-full"
                :required="true"
                :errors="$errors"
            />
        </div>
    </div>

    <div class="flex flex-col items-center justify-between w-full space-y-2 md:flex-row md:space-y-0">
        <a href="{{ route('login') }}" class="link">@lang('fortify::actions.cancel')</a>

        <button type="submit" class="w-full button-primary md:w-auto">
            @lang('fortify::actions.reset_password')
        </button>
    </div>
</form>
