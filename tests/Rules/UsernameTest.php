<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\Username;
use ARKEcosystem\Fortify\Support\Enums\Constants;

it('handle null values', function () {
    $subject = new Username();

    expect($subject->passes('username', null))->toBeFalse();
});

it('will reject if the value starts with a special character', function () {
    $subject = new Username();

    expect($subject->passes('username', '_foo'))->toBeFalse();
    expect($subject->passes('username', '.foo'))->toBeFalse();

    expect($subject->message())->toBe(trans('fortify::validation.messages.username.special_character_start'));
});

it('will reject if the value ends with a special character', function () {
    $subject = new Username();

    expect($subject->passes('username', 'foo_'))->toBeFalse();
    expect($subject->passes('username', 'foo.'))->toBeFalse();

    expect($subject->message())->toBe(trans('fortify::validation.messages.username.special_character_end'));
});

it('will reject if the value contains consecutive special chars', function () {
    $subject = new Username();

    expect($subject->passes('username', 'foo__bar'))->toBeFalse();
    expect($subject->passes('username', 'foo..bar'))->toBeFalse();
    expect($subject->passes('username', 'foo_bar__baz'))->toBeFalse();
    expect($subject->passes('username', 'foo.bar..baz'))->toBeFalse();

    expect($subject->message())->toBe(trans('fortify::validation.messages.username.consecutive_special_characters'));
});

it('will reject if the value contains any forbidden special chars', function () {
    $subject = new Username();

    expect($subject->passes('username', 'foo!bar'))->toBeFalse();
    expect($subject->passes('username', 'foo=bar'))->toBeFalse();
    expect($subject->passes('username', 'foo?bar'))->toBeFalse();
    expect($subject->passes('username', 'foo&baz'))->toBeFalse();
    expect($subject->passes('username', 'foo,baz'))->toBeFalse();
    expect($subject->passes('username', 'foo;baz'))->toBeFalse();

    expect($subject->message())->toBe(trans('fortify::validation.messages.username.forbidden_special_characters'));
});

it('will reject if the value is too short', function () {
    $subject = new Username();

    expect($subject->passes('username', 'a'))->toBeFalse();

    expect($subject->message())
        ->toBe(trans('fortify::validation.messages.username.min_length', [
            'length'    => Constants::MIN_USERNAME_CHARACTERS,
        ]));
});

it('will reject if the value is too long', function () {
    $subject = new Username();

    expect($subject->passes('username', str_repeat('a', 31)))->toBeFalse();

    expect($subject->message())
        ->toBe(trans('fortify::validation.messages.username.max_length', [
            'length'    => Constants::MAX_USERNAME_CHARACTERS,
        ]));
});

it('would not reject if value is using allowed characters', function () {
    $subject = new Username();

    expect($subject->passes('username', 'foo_bar'))->toBeTrue();
    expect($subject->passes('username', 'foo.bar'))->toBeTrue();
    expect($subject->passes('username', 'foo_bar.baz'))->toBeTrue();
    expect($subject->passes('username', 'foo.bar_baz'))->toBeTrue();
    expect($subject->passes('username', 'foo_123'))->toBeTrue();
    expect($subject->passes('username', 'foo.123'))->toBeTrue();
    expect($subject->passes('username', 'foo_123.baz'))->toBeTrue();
    expect($subject->passes('username', 'foo.123_baz'))->toBeTrue();
});

it('will reject if the value contains any uppercase character', function () {
    $subject = new Username();

    expect($subject->passes('username', 'Foo'))->toBeFalse();
    expect($subject->passes('username', 'fOo'))->toBeFalse();
    expect($subject->passes('username', 'foO'))->toBeFalse();
    expect($subject->passes('username', 'Foo_bar'))->toBeFalse();
    expect($subject->passes('username', 'foo_Bar'))->toBeFalse();
    expect($subject->passes('username', 'Foo_Bar'))->toBeFalse();
    expect($subject->passes('username', 'Foo.bar'))->toBeFalse();
    expect($subject->passes('username', 'foo.Bar'))->toBeFalse();
    expect($subject->passes('username', 'Foo.Bar'))->toBeFalse();

    expect($subject->message())->toBe(trans('fortify::validation.messages.username.lowercase_only'));
});

it('will not reject if the value contains only lowercase character', function () {
    $subject = new Username();

    expect($subject->passes('username', 'foo'))->tobeTrue();
    expect($subject->passes('username', 'foo_bar'))->tobeTrue();
    expect($subject->passes('username', 'foo.bar'))->tobeTrue();
});
