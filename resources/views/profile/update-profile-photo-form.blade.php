<div
    x-data="{ isUploading: false, select() { document.getElementById('photo').click(); } }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false"
    class="relative flex flex-col {{ $alignment ?? 'items-center mb-4 md:items-start' }}"
>
    <form wire:submit.prevent="store" id="livewire-form">
        <div
            style="background-image: url('{{ $this->user->photo }}')"
            class="cursor-pointer bg-theme-secondary-200 inline-block bg-contain bg-center bg-no-repeat rounded {{ $dimensions ?? 'w-48 h-48' }}"
            role="button"
        >
            <input
                id="photo"
                type="file"
                class="absolute top-0 hidden block opacity-0 cursor-pointer"
                wire:model="photo"
                accept="image/jpg,image/jpeg,image/bmp,image/png"
            />
        </div>

        <div x-show="isUploading" x-cloak>
            <x-ark-loading-spinner />
        </div>

        <div
            class="cursor-pointer flex items-center justify-center rounded absolute top-0 opacity-0 hover:opacity-90 transition-default bg-theme-secondary-900 {{ $dimensions ?? 'w-48 h-48' }}"
            @click="select()"
            role="button"
        >
            <div>@svg('upload', 'w-4 h-4 text-white')</div>
        </div>
    </form>

    @error('photo')
        <p class="input-help--error">{{ $message }}</p>
    @enderror
</div>
