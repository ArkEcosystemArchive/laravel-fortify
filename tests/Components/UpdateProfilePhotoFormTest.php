<?php

use ARKEcosystem\Fortify\Components\UpdateProfilePhotoForm;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Spatie\MediaLibrary\MediaCollections\FileAdderFactory;
use Tests\MediaUser;

it('can_upload_a_photo', function () {
    $this
        ->mock(FileAdderFactory::class)
        ->shouldReceive('createFromDisk->toMediaCollection')
        ->once();

    $photo = UploadedFile::fake()->image('logo.jpeg');

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('photo', $photo);
});

it('cannot_upload_a_photo_with_disallowed_extension', function () {
    $photo = UploadedFile::fake()->create('logo.gif', 1000, 'image/gif');

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('photo', $photo)
        ->assertHasErrors('photo');
});

it('cannot_upload_a_photo_that_is_too_large', function () {
    $photo = UploadedFile::fake()->image('logo.jpeg')->size(5000);

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('photo', $photo)
        ->assertHasErrors('photo');
});
