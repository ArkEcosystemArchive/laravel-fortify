<?php

namespace ARKEcosystem\Fortify\Models\Concerns;

trait HasPhoto
{
    public function getPhotoAttribute(): string
    {
        return $this->getFirstMediaUrl('photo');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }
}
