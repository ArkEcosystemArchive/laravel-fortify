<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\AllowedCharactersUsername;

it('can pass validation', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->passes('name', 'foo'))->toBeTrue();
    expect($subject->passes('name', '123'))->toBeTrue();
    expect($subject->passes('name', 'foo.123'))->toBeTrue();
    expect($subject->passes('name', 'foo_bar'))->toBeTrue();
    expect($subject->passes('name', 'foo_bar_123'))->toBeTrue();
    expect($subject->passes('name', 'foo_bar_123'))->toBeTrue();
    expect($subject->passes('name', 'foo.bar'))->toBeTrue();
    expect($subject->passes('name', 'foo.bar_baz'))->toBeTrue();
    expect($subject->passes('name', 'foo_bar.baz'))->toBeTrue();
    expect($subject->passes('name', 'foo.bar.baz'))->toBeTrue();
    expect($subject->passes('name', 'FOOBAR'))->toBeTrue();
    expect($subject->passes('name', 'FOO_BAR'))->toBeTrue();
    expect($subject->passes('name', 'FOO.BAR'))->toBeTrue();
    expect($subject->passes('name', 'FOO.123'))->toBeTrue();
    expect($subject->passes('name', 'FOO.123_BAZ'))->toBeTrue();
    expect($subject->passes('name', str_repeat('f', 30)))->toBeTrue();
});

it('can fail validation', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->passes('name', '.'))->toBeFalse();
    expect($subject->passes('name', '_'))->toBeFalse();
    expect($subject->passes('name', '_.'))->toBeFalse();
    expect($subject->passes('name', '_._'))->toBeFalse();
    expect($subject->passes('name', 'fo'))->toBeFalse();
    expect($subject->passes('name', '_f'))->toBeFalse();
    expect($subject->passes('name', '_foo'))->toBeFalse();
    expect($subject->passes('name', '.foo'))->toBeFalse();
    expect($subject->passes('name', '..foo'))->toBeFalse();
    expect($subject->passes('name', '__foo'))->toBeFalse();
    expect($subject->passes('name', 'foo.'))->toBeFalse();
    expect($subject->passes('name', 'foo_'))->toBeFalse();
    expect($subject->passes('name', 'foo__'))->toBeFalse();
    expect($subject->passes('name', 'foo_.'))->toBeFalse();
    expect($subject->passes('name', 'foo__bar'))->toBeFalse();
    expect($subject->passes('name', '_foo_bar'))->toBeFalse();
    expect($subject->passes('name', 'foo-bar'))->toBeFalse();
    expect($subject->passes('name', 'foo..bar'))->toBeFalse();
    expect($subject->passes('name', 'foo--bar'))->toBeFalse();
    expect($subject->passes('name', 'foo bar'))->toBeFalse();
    expect($subject->passes('name', str_repeat('f', 31)))->toBeFalse();
});

it('shows the correct validation message', function () {
    $subject = new AllowedCharactersUsername();

    expect($subject->message())->toBe(trans('fortify::validation.messages.allowed_characters_username'));
});
