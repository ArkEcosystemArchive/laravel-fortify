<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\Username;

it('handle null values', function () {
    $rule = new Username();

    expect($rule->passes('username', null))->toBeFalse();
});

it('will reject if the value starts with a special character', function () {
    $rule = new Username();

    expect($rule->passes('username', '-foo'))->toBeFalse();
    expect($rule->passes('username', '_foo'))->toBeFalse();
    expect($rule->passes('username', '=foo'))->toBeFalse();
    expect($rule->passes('username', '!foo'))->toBeFalse();
    expect($rule->passes('username', '.foo'))->toBeFalse();

    expect($rule->message())->toBe(trans('fortify::validation.messages.username.special_character_start'));
});

it('will reject if the value ends with a special character', function () {
    $rule = new Username();

    expect($rule->passes('username', 'foo-'))->toBeFalse();
    expect($rule->passes('username', 'foo_'))->toBeFalse();
    expect($rule->passes('username', 'foo='))->toBeFalse();
    expect($rule->passes('username', 'foo!'))->toBeFalse();
    expect($rule->passes('username', 'foo.'))->toBeFalse();

    expect($rule->message())->toBe(trans('fortify::validation.messages.username.special_character_end'));
});

it('will reject if the value contains consecutive special chars', function () {
    $rule = new Username();

    expect($rule->passes('username', 'foo__bar'))->toBeFalse();
    expect($rule->passes('username', 'foo--bar'))->toBeFalse();
    expect($rule->passes('username', 'foo..bar'))->toBeFalse();
    expect($rule->passes('username', 'foo-bar__baz'))->toBeFalse();

    expect($rule->message())->toBe(trans('fortify::validation.messages.username.consecutive_special_characters'));
});

it('will reject if the value contains any forbidden special chars', function () {
    $rule = new Username();

    expect($rule->passes('username', 'foo!bar'))->toBeFalse();
    expect($rule->passes('username', 'foo=bar'))->toBeFalse();
    expect($rule->passes('username', 'foo?bar'))->toBeFalse();
    expect($rule->passes('username', 'foo&baz'))->toBeFalse();

    expect($rule->message())->toBe(trans('fortify::validation.messages.username.forbidden_special_characters'));
});

it('will reject if the value is too short', function () {
    expect((new Username())->message())
        ->toBe(':attribute must be at least 3 characters.');
});
