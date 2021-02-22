<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\UserInterface\Components\UploadImageSingle;
use Livewire\Component;

class UpdateProfilePhotoForm extends Component
{
    use InteractsWithUser;
    use UploadImageSingle;

    public string $dimensions = '';

    public string $alignment = '';

    public function mount(string $dimensions = 'w-48 h-48', string $alignment = 'items-center mb-4 md:items-start')
    {
        $this->dimensions = $dimensions;
        $this->alignment  = $alignment;
    }

    public function render(): \Illuminate\View\View
    {
        return view('ark-fortify::profile.update-profile-photo-form');
    }

    public function updatedImageSingle(): void
    {
        $this->validateImageSingle();

        $file = $this->imageSingle->storePubliclyAs('uploads', $this->imageSingle->hashName());

        $this->user->addMediaFromDisk($file)->toMediaCollection('photo');
        $this->user->refresh();
    }

    public function deleteImageSingle(): void
    {
        $this->user->getFirstMedia('photo')->delete();
        $this->user->refresh();
    }
}
