<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\UserInterface\Components\UploadImage;

class UpdateProfilePhotoForm extends UploadImage
{
    use InteractsWithUser;

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.update-profile-photo-form');
    }

    public function store()
    {
        $this->validate([
            'photo' => $this->validators(),
        ]);

        $file = $this->photo->storePubliclyAs('uploads', $this->photo->hashName());

        $this->user->addMediaFromDisk($file)->toMediaCollection('photo');
        $this->user->refresh();
    }

    public function delete()
    {
        $this->user->getFirstMedia('photo')->delete();
        $this->user->refresh();
    }
}
