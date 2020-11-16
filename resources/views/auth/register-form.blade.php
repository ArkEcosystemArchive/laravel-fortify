<form
    method="POST"
    action="{{ $formUrl }}"
    class="flex flex-col p-8 mx-4 border rounded-lg border-theme-secondary-200 md:mx-0 lg:p-8 xl:mx-8"
>
    @csrf

    @if($invitation)
        <input type="hidden" name="name" value="{{ $invitation->name }}" />
    @else
        <div class="mb-8">
            <div class="flex flex-1">
                <x-ark-input
                    model="state.name"
                    name="name"
                    :label="trans('fortify::forms.name')"
                    autocomplete="name"
                    class="w-full"
                    :autofocus="true"
                    :required="true"
                    :errors="$errors"
                />
            </div>
        </div>
    @endif

    @if(Config::get('fortify.username_alt'))
        <div class="mb-8">
            <div class="flex flex-1">
                <x-ark-input
                    model="state.username"
                    type="text"
                    name="username"
                    :label="trans('fortify::forms.username')"
                    autocomplete="username"
                    class="w-full"
                    :required="true"
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
                    model="state.email"
                    type="email"
                    name="email"
                    :label="trans('fortify::forms.email')"
                    autocomplete="email"
                    class="w-full"
                    :required="true"
                    :errors="$errors"
                />
            </div>
        </div>
    @endif

    <x:ark-fortify::password-rules class="mb-4" :password-rules="$passwordRules">
        <x-ark-input
            model="state.password"
            type="password"
            name="password"
            :label="trans('fortify::forms.password')"
            autocomplete="new-password"
            class="w-full mb-2"
            :required="true"
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

    <div class="mb-8">
        <x-ark-checkbox
            model="state.terms"
            name="terms"
            :errors="$errors"
        >
            @slot('label')
                @lang('fortify::auth.register-form.conditions', ['termsOfServiceRoute' => route('terms-of-service'), 'privacyPolicyRoute' => route('privacy-policy'), 'notificationSettingsRoute' => route('notification-settings')])
            @endslot
        </x-ark-checkbox>

        @error('terms')
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-4 pb-4 text-right">
        <button type="submit" class="w-full button-secondary sm:w-auto">
            @lang('fortify::auth.register-form.sign_up')
        </button>
    </div>
</form>
