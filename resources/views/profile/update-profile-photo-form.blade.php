<div class="relative flex flex-col {{ $alignment }}">
    <form wire:submit.prevent="store" id="livewire-form" class="{{ $formClass}}">
        <x-ark-upload-image-single
            id="profile-image"
            :readonly="$readonly"
            :dimensions="$dimensions"
            :image="$this->user->photo"
            :upload-text="__('fortify::forms.upload-avatar.upload_avatar')"
            :delete-tooltip="__('fortify::forms.upload-avatar.delete_avatar')"
        />
    </form>

    @error('singleImage')
        <p class="input-help--error">{{ $message }}</p>
    @enderror
</div>
