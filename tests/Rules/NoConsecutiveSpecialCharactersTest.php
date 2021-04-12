<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\NoConsecutiveSpecialCharacters;

it('doesnt accept a name with two consecutive special characters ', function ($name) {
    $rule = new NoConsecutiveSpecialCharacters();
    $this->assertFalse($rule->passes('name', $name));
})->with([
    'hello--',
    '..hello',
    'some.*string',
    'test$=2222',
]);

it('accepts a name with no consecutive special characters ', function ($name) {
    $rule = new NoConsecutiveSpecialCharacters();
    $this->assertTrue($rule->passes('name', $name));
})->with([
    'hell-o-',
    '.hello.',
    'some*s.tring',
    '$test$2222$',
]);

it('has a message', function () {
    $rule = new NoConsecutiveSpecialCharacters();
    $this->assertEquals(trans('fortify::validation.messages.no_consecutive_characters'), $rule->message());
});
