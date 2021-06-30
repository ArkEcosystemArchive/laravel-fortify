<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\UpdatePasswordForm;
use Livewire\Livewire;
use function Tests\createUserModel;
use Illuminate\Contracts\Validation\UncompromisedVerifier;

beforeEach(function () {
    $this->mock(UncompromisedVerifier::class)->shouldReceive('verify')->andReturn(true);
});

it('can interact with the form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', 'abcd1234ABCD%')
        ->set('password_confirmation', 'abcd1234ABCD%')
        ->call('updatePassword')
        ->assertDispatchedBrowserEvent('updated-password');
});

it('clears password rules on update', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->set('currentPassword', 'password')
        ->set('password', 'abcd1234ABCD%')
        ->set('password_confirmation', 'abcd1234ABCD%')
        ->assertSet('passwordRules', [
            'lowercase'  => true,
            'uppercase'  => true,
            'numbers'    => true,
            'symbols'    => true,
            'min'        => true,
        ])
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'lowercase'  => false,
            'uppercase'  => false,
            'numbers'    => false,
            'symbols'    => false,
            'min'        => false,
        ]);
});

it('handles password being null', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', null)
        ->set('password_confirmation', null)
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'lowercase'  => false,
            'uppercase'  => false,
            'numbers'    => false,
            'symbols'    => false,
            'min'        => false,
        ]);
});
