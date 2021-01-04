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
        ->set('photo', $photo);
});

it('cannot upload a photo with disallowed extension', function () {
    $photo = UploadedFile::fake()->create('logo.gif', 1000, 'image/gif');

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('photo', $photo)
        ->assertHasErrors('photo');
});

it('cannot upload a photo that is too large', function () {
    $photo = UploadedFile::fake()->image('logo.jpeg')->size(5000);

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('photo', $photo)
        ->assertHasErrors('photo');
});

it('can have custom dimensions', function () {
    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->assertSet('dimensions', null)
        ->assertSee('w-48 h-48')
        ->assertDontSee('w-24 h-24')
        ->set('dimensions', 'w-24 h-24')
        ->assertSet('dimensions', 'w-24 h-24')
        ->assertSee('w-24 h-24');
});

it('can have a custom alignment', function () {
    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->assertSet('alignment', null)
        ->assertSee('items-center mb-4 md:items-start')
        ->set('alignment', 'items-end')
        ->assertSet('alignment', 'items-end')
        ->assertSee('items-end')
        ->assertDontSee('items-center mb-4 md:items-start');
});
