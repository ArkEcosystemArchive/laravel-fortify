<div
    x-data="{ isUploading: false, select() { document.getElementById('photo').click(); } }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false"
    class="relative flex flex-col {{ $alignment ?? 'items-center mb-4 md:items-start' }}"
>
    <form wire:submit.prevent="store" id="livewire-form">
        <x-ark-upload-image
            :image="$this->user->photo"
            :upload-text="__('fortify::forms.upload-avatar.upload_avatar')"
            :delete-tooltip="__('fortify::forms.upload-avatar.delete_avatar')"
        />
    </form>

    @error('photo')
        <p class="input-help--error">{{ $message }}</p>
    @enderror
</div>
