<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Components\UpdateProfilePhotoForm;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Spatie\MediaLibrary\MediaCollections\FileAdderFactory;
use Tests\MediaUser;

it('can upload a photo', function () {
    $this
        ->mock(FileAdderFactory::class)
        ->shouldReceive('createFromDisk->toMediaCollection')
        ->once();

    $photo = UploadedFile::fake()->image('logo.jpeg');

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', $photo);
});

it('cannot upload a photo with disallowed extension', function () {
    $photo = UploadedFile::fake()->create('logo.gif', 1000, 'image/gif');

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', $photo)
        ->assertHasErrors('imageSingle');
});

it('cannot upload a photo that is too large', function () {
    $photo = UploadedFile::fake()->image('logo.jpeg')->size(5000);

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', $photo)
        ->assertHasErrors('imageSingle');
});
