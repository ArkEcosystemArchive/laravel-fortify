<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Components\UpdateProfilePhotoForm;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Spatie\MediaLibrary\MediaCollections\FileAdderFactory;
use Spatie\MediaLibrary\MediaCollections\MediaRepository;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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

it('can delete a photo', function () {
    $this
        ->mock(FileAdderFactory::class)
        ->shouldReceive('createFromDisk->toMediaCollection')
        ->once();

    $media = Mockery::mock(Media::class);
    $media->shouldReceive('delete');

    $collection = Mockery::mock(MediaCollection::class);
    $collection
        ->shouldReceive('collectionName')
        ->andReturnSelf();
    $collection
        ->shouldReceive('first')
        ->andReturn($media);

    $this->mock(MediaRepository::class)
        ->shouldReceive('getCollection')
        ->andReturn($collection);

    $photo = UploadedFile::fake()
        ->image('logo.jpeg')
        ->size(1);

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', $photo)
        ->call('deleteImageSingle')
        ->assertHasNoErrors('imageSingle');
});
