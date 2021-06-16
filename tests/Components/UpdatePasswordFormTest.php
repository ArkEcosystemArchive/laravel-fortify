<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\UpdatePasswordForm;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can interact with the form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('passwordConfirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', 'abcd1234ABCD%')
        ->set('passwordConfirmation', 'abcd1234ABCD%')
        ->call('updatePassword')
        ->assertDispatchedBrowserEvent('updated-password');
});

it('clears password rules on update', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->set('currentPassword', 'password')
        ->set('password', 'abcd1234ABCD%')
        ->set('passwordConfirmation', 'abcd1234ABCD%')
        ->assertSet('passwordRules', [
            'needsLowercase'        => true,
            'needsUppercase'        => true,
            'needsNumeric'          => true,
            'needsSpecialCharacter' => true,
            'needsMinimumLength'    => true,
        ])
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'needsLowercase'        => false,
            'needsUppercase'        => false,
            'needsNumeric'          => false,
            'needsSpecialCharacter' => false,
            'needsMinimumLength'    => false,
        ]);
});

it('handles password being null', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('passwordConfirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', null)
        ->set('passwordConfirmation', null)
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'needsLowercase'        => false,
            'needsUppercase'        => false,
            'needsNumeric'          => false,
            'needsSpecialCharacter' => false,
            'needsMinimumLength'    => false,
        ]);
});
