<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\AllowedCharactersUsername;

it('can pass validation', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->passes('name', 'foo'))->toBeTrue();
    expect($subject->passes('name', 'foo-bar'))->toBeTrue();
    expect($subject->passes('name', 'foo-bar-baz'))->toBeTrue();
    expect($subject->passes('name', 'fooBar-baz'))->toBeTrue();
    expect($subject->passes('name', 'FOOBARBAZ'))->toBeTrue();
    expect($subject->passes('name', 'foo-BAR-baz'))->toBeTrue();
    expect($subject->passes('name', 'foo-BAR-baz1'))->toBeTrue();
    expect($subject->passes('name', 'foo-BAR-baz-1'))->toBeTrue();
    expect($subject->passes('name', '1-foo'))->toBeTrue();
    expect($subject->passes('name', '1foo'))->toBeTrue();
    expect($subject->passes('name', 'FOO1'))->toBeTrue();
});

it('can fail validation', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->passes('name', '.'))->toBeFalse();
    expect($subject->passes('name', '..'))->toBeFalse();
    expect($subject->passes('name', '......'))->toBeFalse();
    expect($subject->passes('name', '.foo'))->toBeFalse();
    expect($subject->passes('name', '.foo-'))->toBeFalse();
    expect($subject->passes('name', 'foo-'))->toBeFalse();
    expect($subject->passes('name', '-foo-'))->toBeFalse();
    expect($subject->passes('name', '-foo'))->toBeFalse();
    expect($subject->passes('name', 'foo_bar'))->toBeFalse();
    expect($subject->passes('name', 'foo-bar-1-'))->toBeFalse();
    expect($subject->passes('name', '-foo-bar-1'))->toBeFalse();
    expect($subject->passes('name', 'foo-bar-1-'))->toBeFalse();
    expect($subject->passes('name', 'foo--bar'))->toBeFalse();
    expect($subject->passes('name', 'FOO-BAR-'))->toBeFalse();
    expect($subject->passes('name', '-FOO-BAR-'))->toBeFalse();
    expect($subject->passes('name', 'foo--1'))->toBeFalse();
});

it('shows the correct validation message', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->message())->toBe(trans('fortify::validation.messages.allowed_characters_username'));
});
