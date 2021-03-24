<div class="flex-1">
    <x-ark-input-with-icon
        type="email"
        id="subscribe_email"
        name="subscribe_email"
        placeholder="Enter your e-mail"
        model="email"
        keydown-enter="subscribe"
        autocomplete="email"
        input-class="w-full"
        container-class="overflow-hidden rounded-lg"
        :errors="$errors"
        :hide-label="true"
    >
        <button wire:click="subscribe" class="block px-2 text-theme-secondary-500">
            @svg('paper-plane', 'w-5 h-5')
        </button>
    </x-ark-input-with-icon>

    @error('email')
        <div class="mt-1 text-sm font-semibold">{{ $message }}</div>
    @enderror

    @error('list')
        <div class="mt-1 text-sm font-semibold">{{ $message }}</div>
    @enderror

    @if($status)
        @if($subscribed)
            <div class="mt-1 text-sm font-semibold text-theme-success-600">{{ $status }}</div>
        @else
            <div class="mt-1 text-sm font-semibold">{{ $status }}</div>
        @endif
    @endif
</div>
