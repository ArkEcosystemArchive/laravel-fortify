<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Actions\SubscribeToNewsletter;

use function Tests\expectValidationError;

it('should validate email is required', function () {
    expectValidationError(
        fn () => resolve(SubscribeToNewsletter::class)->execute('', 'subscribers'),
        'email',
        'The email field is required.'
    );
});

it('should validate email is invalid', function () {
    expectValidationError(
        fn () => resolve(SubscribeToNewsletter::class)->execute('invalid email', 'subscribers'),
        'email',
        'The email must be a valid email address.'
    );
});

it('should validate list', function () {
    expectValidationError(
        fn () => resolve(SubscribeToNewsletter::class)->execute('email@email.com', 'test list'),
        'list',
        'The selected list is invalid.'
    );
});

it('should return false if not subscribed', function () {
    resolve(SubscribeToNewsletter::class)->execute('email@email.com', 'subscribers');
})->skip();
