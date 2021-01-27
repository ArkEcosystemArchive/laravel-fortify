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
        ->assertEmitted('saved');
});
