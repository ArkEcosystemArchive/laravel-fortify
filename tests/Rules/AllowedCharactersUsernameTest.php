<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\AllowedCharactersUsername;

it('can pass validation', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->passes('name', 'foo'))->toBeTrue();
    expect($subject->passes('name', 'foo_bar'))->toBeTrue();
    expect($subject->passes('name', 'foo_bar='))->toBeTrue();
});

it('can fail validation', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->passes('name', '.'))->toBeFalse();
    expect($subject->passes('name', '..'))->toBeFalse();
    expect($subject->passes('name', '=!.'))->toBeFalse();
});

it('shows the correct validation message', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->message())->toBe(trans('fortify::validation.messages.allowed_characters_username'));
});
