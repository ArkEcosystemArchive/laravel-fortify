<form
    method="POST"
    action="{{ $formUrl }}"
    class="flex flex-col p-8 mx-4 border-2 rounded-lg border-theme-secondary-200"
    x-data="{isTyping: false}"
>
    @csrf

    @if(Config::get('fortify.username_alt'))
        <div class="mb-8">
            <div class="flex flex-1">
                <x-ark-input
                    wire:model.defer="state.username"
                    no-model
                    type="text"
                    name="username"
                    :label="trans('fortify::forms.username')"
                    autocomplete="username"
                    autocapitalize="none"
                    class="w-full"
                    :errors="$errors"
                />
            </div>
        </div>
    @endif

    @if($invitation)
        <input type="hidden" name="name" value="{{ $invitation->name }}" />
    @else
        <div class="mb-8">
            <div class="flex flex-1">
                <x-ark-input
                    wire:model.defer="state.name"
                    no-model
                    name="name"
                    :label="trans('fortify::forms.display_name')"
                    autocomplete="name"
                    autocapitalize="none"
                    class="w-full"
                    :autofocus="true"
                    :errors="$errors"
                />
            </div>
        </div>
    @endif

    @if($invitation)
        <input type="hidden" name="email" value="{{ $invitation->email }}" />
    @else
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
                    :errors="$errors"
                />
            </div>
        </div>
    @endif

    <x:ark-fortify::password-rules class="mb-8" :password-rules="$passwordRules" is-typing="isTyping" rules-wrapper-class="grid grid-cols-1 gap-4 mt-4">
        <x-ark-input
            model="state.password"
            type="password"
            name="password"
            :label="trans('fortify::forms.password')"
            autocomplete="new-password"
            class="w-full mb-2"
            @keydown="isTyping=true"
            :errors="$errors"
        />
    </x:ark-fortify::password-rules>

    <div class="mb-4">
        <div class="flex flex-1">
            <x-ark-input
                model="state.password_confirmation"
                type="password"
                name="password_confirmation"
                :label="trans('fortify::forms.confirm_password')"
                autocomplete="new-password"
                class="w-full"
                :errors="$errors"
            />
        </div>
    </div>

    <div class="mb-8">
        <x-ark-checkbox
            model="state.terms"
            name="terms"
            :errors="$errors"
        >
            @slot('label')
                @lang('fortify::auth.register-form.conditions', ['termsOfServiceRoute' => route('terms-of-service'), 'privacyPolicyRoute' => route('privacy-policy')])
            @endslot
        </x-ark-checkbox>

        @error('terms')
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>

    <div class="text-right">
        <button type="submit" class="w-full button-secondary sm:w-auto">
            @lang('fortify::actions.sign_up')
        </button>
    </div>
</form>
