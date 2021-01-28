<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\Password;

it('can check for lowercase requirements', function () {
    $rule = (new Password())->requireLowercase();

    expect($rule->passes('password', 'abcdefghi'))->toBeTrue();
    expect($rule->passes('password', 'ABCDEFGHI'))->toBeFalse();
    expect($rule->passes('password', '123456789'))->toBeFalse();
    expect($rule->passes('password', '         '))->toBeFalse();
    expect($rule->passes('password', '#########'))->toBeFalse();
});

it('can check for uppercase requirements', function () {
    $rule = (new Password())->requireUppercase();

    expect($rule->passes('password', 'abcdefghi'))->toBeFalse();
    expect($rule->passes('password', 'ABCDEFGHI'))->toBeTrue();
    expect($rule->passes('password', '123456789'))->toBeFalse();
    expect($rule->passes('password', '         '))->toBeFalse();
    expect($rule->passes('password', '#########'))->toBeFalse();
});

it('can check for numeric requirements', function () {
    $rule = (new Password())->requireNumeric();

    expect($rule->passes('password', 'abcdefghi'))->toBeFalse();
    expect($rule->passes('password', 'ABCDEFGHI'))->toBeFalse();
    expect($rule->passes('password', '123456789'))->toBeTrue();
    expect($rule->passes('password', '         '))->toBeFalse();
    expect($rule->passes('password', '#########'))->toBeFalse();
});

it('can check for special characters requirements', function () {
    $rule = (new Password())->requireSpecialCharacter();

    expect($rule->passes('password', 'abcdefghi'))->toBeFalse();
    expect($rule->passes('password', 'ABCDEFGHI'))->toBeFalse();
    expect($rule->passes('password', '123456789'))->toBeFalse();
    expect($rule->passes('password', '         '))->toBeTrue();
    expect($rule->passes('password', '#########'))->toBeTrue();
});

it('can provider feedback on what was wrong', function () {
    expect((new Password())->requireUppercase()->message())
        ->toBe('The :attribute must be at least 8 characters and contain at least one uppercase character.');

    expect((new Password())->requireNumeric()->message())
        ->toBe('The :attribute must be at least 8 characters and contain at least one number.');

    expect((new Password())->requireSpecialCharacter()->message())
        ->toBe('The :attribute must be at least 8 characters and contain at least one special character.');

    expect((new Password())->requireUppercase()->requireNumeric()->message())
        ->toBe('The :attribute must be at least 8 characters and contain at least one uppercase character and one number.');

    expect((new Password())->requireUppercase()->requireSpecialCharacter()->message())
        ->toBe('The :attribute must be at least 8 characters and contain at least one uppercase character and one special character.');

    expect((new Password())->requireUppercase()->requireNumeric()->requireSpecialCharacter()->message())
        ->toBe('The :attribute must be at least 8 characters and contain at least one uppercase character, one number, and one special character.');

    expect((new Password())->message())
        ->toBe('The :attribute must be at least 8 characters.');

    expect((new Password())->withMessage('hello')->message())
        ->toBe('hello');
});
