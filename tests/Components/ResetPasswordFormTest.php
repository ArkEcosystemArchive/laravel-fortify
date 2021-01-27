<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\ResetPasswordForm;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can interact with the form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(ResetPasswordForm::class)
        ->assertSet('state', [
            'email'                 => null,
            'password'              => '',
            'password_confirmation' => '',
        ])
        ->assertViewIs('ark-fortify::auth.reset-password-form');
});
