<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfilePhotoForm extends Component
{
    use InteractsWithUser;
    use WithFileUploads;

    public $alignment;

    public $photo;

    public $dimensions;

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.update-profile-photo-form');
    }

    public function updatedPhoto()
    {
        $this->store();
    }

    public function store()
    {
        $this->validate([
            'photo' => ['mimes:jpeg,png,bmp,jpg', 'max:2048'],
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
