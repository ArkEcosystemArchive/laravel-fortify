<form
    method="POST"
    action="{{ $formUrl }}"
    class="flex flex-col p-8 mx-4 border rounded-lg border-theme-secondary-200 md:mx-0 lg:p-8 xl:mx-8"
>
    @csrf

    @if($invitation)
        <input type="hidden" name="name" value="{{ $invitation->name }}" />
    @else
        <div class="mb-4">
            <div class="flex flex-1">
                <x-ark-input
                    name="name"
                    label="Name"
                    autocomplete="name"
                    class="w-full"
                    :autofocus="true"
                    :required="true"
                    :errors="$errors"
                />
            </div>
        </div>
    @endif

    <div class="mb-4">
        <div class="flex flex-1">
            <x-ark-input
                type="text"
                name="username"
                label="Username"
                autocomplete="username"
                class="w-full"
                :required="true"
                :errors="$errors"
            />
        </div>
    </div>

    @if($invitation)
        <input type="hidden" name="email" value="{{ $invitation->email }}" />
    @else
        <div class="mb-4">
            <div class="flex flex-1">
                <x-ark-input
                    type="email"
                    name="email"
                    label="Email"
                    autocomplete="email"
                    class="w-full"
                    :required="true"
                    :errors="$errors"
                />
            </div>
        </div>
    @endif

    <x-auth.password-rules class="mb-4" :password-rules="$passwordRules">
        <x-ark-input
            type="password"
            name="password"
            label="Password"
            autocomplete="new-password"
            class="w-full"
            :required="true"
            :errors="$errors"
        />
    </x-auth.password-rules>

    <div class="mb-4">
        <div class="flex flex-1">
            <x-ark-input
                type="password"
                name="password_confirmation"
                label="Confirm Password"
                autocomplete="new-password"
                class="w-full"
                :required="true"
                :errors="$errors"
            />
        </div>
    </div>

    <div class="mb-4">
        <x-ark-checkbox
            name="terms"
            :errors="$errors"
        >
            @slot('label')
                Creating an account means you're okay with our
                <a href="{{ route('terms-of-service') }}" class="link">Terms of Service</a> and
                <a href="{{ route('privacy-policy') }}" class="link">Privacy Policy</a>.
            @endslot
        </x-ark-checkbox>

        @error('terms')
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-4 text-right">
        <button type="submit" class="w-full button-primary md:w-auto">
            Create Account
        </button>
    </div>

    <div class="text-center">
        <div class="pt-4 mt-8 border-t border-theme-secondary-200">
            Already a member? <a href="/login" class="link">Sign in</a>
        </div>
    </div>
</form>