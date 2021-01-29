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

    protected $listeners = ['uploadError'];

    public function uploadError()
    {
        $this->emit('toastMessage', [trans('fortify::forms.upload-avatar.upload_error'), 'error']);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.update-profile-photo-form');
    }

    public function updatedImageSingle()
    {
        $this->validate([
            'imageSingle' => $this->imageSingleValidators(),
        ]);

        $file = $this->imageSingle->storePubliclyAs('uploads', $this->imageSingle->hashName());

        $this->user->addMediaFromDisk($file)->toMediaCollection('photo');
        $this->user->refresh();
    }

    public function deleteImageSingle()
    {
        $this->user->getFirstMedia('photo')->delete();
        $this->user->refresh();
    }
}
