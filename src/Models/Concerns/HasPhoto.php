<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Models\Concerns;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasPhoto
{
    use InteractsWithMedia;

    public function getPhoto(): ?Media
    {
        return $this->getFirstMedia('photo');
    }

    public function getPhotoAttribute(): string
    {
        return $this->getFirstMediaUrl('photo');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            // @codeCoverageIgnoreStart
            ->registerMediaConversions(function () {
                $conversions =  collect(config('ui.media.conversions'));

                $conversions->each(function ($size, $name) {
                    $this
                        ->addMediaConversion($name)
                        ->width($size)
                        ->height($size);

                    collect(config('ui.media.srcset_sizes'))->each(fn ($x) => $this
                        ->addMediaConversion($name.$x.'x')
                        ->width($size * $x)
                        ->height($size * $x));
                });
            });
        // @codeCoverageIgnoreEnd
    }
}
