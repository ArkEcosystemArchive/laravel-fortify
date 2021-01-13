<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Models\Concerns;

use Spatie\MediaLibrary\InteractsWithMedia;

trait HasPhoto
{
    use InteractsWithMedia;

    public function getPhotoAttribute(): string
    {
        return $this->getFirstMediaUrl('photo');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }
}
