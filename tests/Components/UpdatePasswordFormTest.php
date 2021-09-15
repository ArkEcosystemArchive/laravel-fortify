<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\UpdatePasswordForm;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Illuminate\Validation\NotPwnedVerifier;
use Livewire\Livewire;
use Mockery\MockInterface;

use function Tests\createUserModel;

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
        ->assertDispatchedBrowserEvent('updated-password')
        ->assertEmitted('toastMessage', [trans('fortify::pages.user-settings.password_updated'), 'success']);
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
            'leak'       => true,
        ])
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'lowercase'  => false,
            'uppercase'  => false,
            'numbers'    => false,
            'symbols'    => false,
            'min'        => false,
            'leak'       => false,
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
            'leak'       => false,
        ]);
});

it('handles password being empty string', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'lowercase'  => false,
            'uppercase'  => false,
            'numbers'    => false,
            'symbols'    => false,
            'min'        => false,
            'leak'       => false,
        ]);
});

// TODO: Unsure of why the mocking isn't working
it('handles password being leaked', function () {
    $mock = $this->mock(NotPwnedVerifier::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('verify')
            ->with([
                'value'     => 'Password!1234',
                'threshold' => 0,
            ])
            ->andReturn(false);
    });

    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', 'Password!1234')
        ->set('password_confirmation', 'Password!1234')
        ->assertSet('passwordRules', [
            'lowercase'  => true,
            'uppercase'  => true,
            'numbers'    => true,
            'symbols'    => true,
            'min'        => true,
            'leak'       => false,
        ]);
})->skip();

it('clears password values', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->set('currentPassword', 'password')
        ->set('password', 'abcd1234ABCD%')
        ->set('password_confirmation', 'abcd1234ABCD%')
        ->call('updatePassword')
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '');
});
