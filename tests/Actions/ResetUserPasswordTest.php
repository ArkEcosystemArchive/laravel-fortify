<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Actions\ResetUserPassword;

use function Tests\createUserModel;
use function Tests\expectValidationError;

it('should reset the user password', function () {
    $user = createUserModel();

    expect($user->password)->toBe('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

    resolve(ResetUserPassword::class)->reset($user, [
        'password' => 'Pas3w05d&123456',
        'password_confirmation' => 'Pas3w05d&123456',
    ]);

    expect($user->password)->not()->toBe('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
});

it('should throw an exception if the password is too short', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(ResetUserPassword::class)->reset($user, [
        'password' => 'passwordpassword',
    ]), 'password', 'The password must be at least 12 characters and contain at least one uppercase character, one number, and one special character.');
});

it('should throw an exception if the password is too weak', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(ResetUserPassword::class)->reset($user, [
        'password' => 'weak',
    ]), 'password', 'The password must be at least 12 characters and contain at least one uppercase character, one number, and one special character.');
});

it('should throw an exception if the password is not confirmed', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(ResetUserPassword::class)->reset($user, [
        'password' => 'Pas3w05d&123456',
    ]), 'password', 'The password confirmation does not match.');
});

it('should throw an exception if the password confirmation does not match', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(ResetUserPassword::class)->reset($user, [
        'password' => 'Pas3w05d&123456',
        'password_confirmation' => 'password',
    ]), 'password', 'The password confirmation does not match.');
});
