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
        ->assertSet('state', [
            'current_password'      => '',
            'password'              => '',
            'password_confirmation' => '',
        ])
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('state.current_password', 'password')
        ->set('state.password', 'abcd1234ABCD%')
        ->set('state.password_confirmation', 'abcd1234ABCD%')
        ->call('updatePassword')
        ->assertDispatchedBrowserEvent('updated-password');
});

it('clears password rules on update', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->set('state.current_password', 'password')
        ->set('state.password', 'abcd1234ABCD%')
        ->set('state.password_confirmation', 'abcd1234ABCD%')
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
        ->assertSet('state', [
            'current_password'      => '',
            'password'              => '',
            'password_confirmation' => '',
        ])
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('state.current_password', 'password')
        ->set('state.password', null)
        ->set('state.password_confirmation', null)
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'needsLowercase'        => false,
            'needsUppercase'        => false,
            'needsNumeric'          => false,
            'needsSpecialCharacter' => false,
            'needsMinimumLength'    => false,
        ]);
});
