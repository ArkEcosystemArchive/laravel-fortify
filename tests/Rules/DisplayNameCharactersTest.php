<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\DisplayNameCharacters;

it('accepts name with regular characters', function ($name) {
    $rule = new DisplayNameCharacters();
    $this->assertTrue($rule->passes('name', $name));
})->with([
    'Elon Tusk',
    'Rick Astley',
    'Los Pollos Hermanos',
    'Alix',
    'H4nn3 Andersen',
    'Hans',
    'Michel The 3rd',
    '3llo',
]);

it('accepts name with unicode characters', function ($name) {
    $rule = new DisplayNameCharacters();
    $this->assertTrue($rule->passes('name', $name));
})->with([
    'André Svenson',
    'John Elkjærd',
    'X Æ A-12',
    'Ñoño',
    'François Hollande',
    'Jean-François d\'Abiguäel',
    'Père Noël',
    'Alfonso & sons',
    'Coca.Cola',
    'Procter, Cremin and Crist',
]);

it('accepts name with single quote', function () {
    $rule = new DisplayNameCharacters();
    $this->assertTrue($rule->passes('name', 'Marco d\'Almeida'));
});

it('doesnt accept other special characters', function ($name) {
    $rule = new DisplayNameCharacters();
    $this->assertFalse($rule->passes('name', $name));
})->with([
    'Martin Henriksen!',
    '@alfonsobries',
    'php=cool',
]);

it('has a message', function () {
    $rule = new DisplayNameCharacters();
    $this->assertEquals(trans('fortify::validation.messages.some_special_characters'), $rule->message());
});
