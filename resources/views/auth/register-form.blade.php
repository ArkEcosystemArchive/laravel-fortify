<form
    method="POST"
    action="{{ $formUrl }}"
    class="flex flex-col px-4 py-8 mx-4 border-2 sm:px-8 rounded-xl border-theme-secondary-200"
    x-data="{isTyping: false}"
>
    @csrf

    @if($invitation)
        <input type="hidden" name="name" value="{{ $invitation->name }}" />
        <input type="hidden" name="email" value="{{ $invitation->email }}" />
    @endif

    <div class="space-y-5">
        @if(Config::get('fortify.username_alt'))
            <div>
                <div class="flex flex-1">
                    <x-ark-input
                        wire:model.defer="state.username"
                        no-model
                        type="text"
                        name="username"
                        :label="trans('fortify::forms.username')"
                        autocomplete="username"
                        class="w-full"
                        :errors="$errors"
                    />
                </div>
            </div>
        @endif

        @unless($invitation)
            <div>
                <div class="flex flex-1">
                    <x-ark-input
                        wire:model.defer="state.name"
                        no-model
                        name="name"
                        :label="trans('fortify::forms.display_name')"
                        autocomplete="name"
                        class="w-full"
                        :autofocus="true"
                        :errors="$errors"
                    />
                </div>
            </div>

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
                        :errors="$errors"
                    />
                </div>
            </div>
        @endunless

        <x:ark-fortify::password-rules :password-rules="$passwordRules" is-typing="isTyping" rules-wrapper-class="grid grid-cols-1 gap-4 my-4">
            <x-ark-input
                model="state.password"
                type="password"
                name="password"
                :label="trans('fortify::forms.password')"
                autocomplete="new-password"
                class="w-full"
                @keydown="isTyping=true"
                :errors="$errors"
            />
        </x:ark-fortify::password-rules>

        <div>
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

        <div>
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
    </div>
</form>
