<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Actions\UpdateUserProfileInformation;
use function Tests\createUserModel;
use function Tests\expectValidationError;

use Tests\UserWithNotifications;
use Tests\UserWithoutVerification;

it('should update the profile information', function () {
    $user = createUserModel(UserWithoutVerification::class);

    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@doe.com');

    resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => 'jane@doe.com',
    ]);

    expect($user->name)->toBe('Jane Doe');
    expect($user->email)->toBe('jane@doe.com');
});

it('should update the profile information for a user that requires verification', function () {
    $user = createUserModel(UserWithNotifications::class);

    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@doe.com');
    expect($user->email_verified_at)->not()->toBeNull();

    resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => 'jane@doe.com',
    ]);

    expect($user->name)->toBe('Jane Doe');
    expect($user->email)->toBe('jane@doe.com');
    expect($user->email_verified_at)->toBeNull();
});

it('should throw an exception if the name is missing', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => null,
        'email' => 'jane@doe.com',
    ]), 'name', 'The name field is required.');
});

it('should throw an exception if the name is too long', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => str_repeat('a', 33),
        'email' => 'jane@doe.com',
    ]), 'name', 'The name may not be greater than 32 characters.');
});

it('should throw an exception if the email is missing', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => null,
    ]), 'email', 'The email field is required.');
});

it('should throw an exception if the email is too long', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => str_repeat('#', 256).'@doe.com',
    ]), 'email', 'The email may not be greater than 255 characters.');
});

it('should throw an exception if the email is not an email', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => str_repeat('#', 256),
    ]), 'email', 'The email must be a valid email address.');
});

it('should not update the profile information if the name of the user contain profanity', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Penis Doe',
        'email' => 'jane@doe.com',
    ]), 'name', trans('fortify::validation.messages.polite_username'));
});

it('should not update the profile information if the name of the user is only composed of special characters', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => '.',
        'email' => 'jane@doe.com',
    ]), 'name', trans('fortify::validation.messages.allowed_characters_username'));
});
