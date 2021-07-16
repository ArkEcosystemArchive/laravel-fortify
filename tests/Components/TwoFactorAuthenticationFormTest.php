<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Components\TwoFactorAuthenticationForm;
use Livewire\Livewire;
use PragmaRX\Google2FALaravel\Google2FA;

use function Tests\createUserModel;

it('can interact with the form', function () {
    $user = createUserModel();

    $g2FA = $this->mock(Google2FA::class);
    $g2FA->shouldReceive('verifyKey')
        ->andReturnTrue();
    app()->instance('pragmarx.google2fa', $g2FA);

    $two_factor_secret = 'QHBRXHLWOT3B2T3L';
    Livewire::actingAs($user)
        ->test(TwoFactorAuthenticationForm::class)
        ->assertSee('You have not enabled two factor authentication.')
        ->set('state.two_factor_secret', $two_factor_secret)
        ->assertSet('enabled', false)
        ->assertSee($two_factor_secret)
        ->set('state.otp', '8437339')
        ->call('enableTwoFactorAuthentication')
        ->assertHasErrors(['state.otp' => 'digits'])
        ->set('state.otp', '843733')
        ->call('enableTwoFactorAuthentication')
        ->assertSee('Two-Factor Authentication Recovery Codes')
        ->assertSee('If you lose your two-factor authentication device')
        ->call('regenerateRecoveryCodes')
        ->assertSee('Two-Factor Authentication Recovery Codes')
        ->call('hideRecoveryCodes')
        ->assertSee('You have enabled two factor authentication')
        // Show recovery codes
        ->call('showRecoveryCodesConfirmationModal')
        ->assertSee('Input your password to show your emergency two-factor recovery codes.')
        ->set('confirmedPassword', 'password')
        ->call('submitConfirmPassword')
        ->assertSee('If you lose your two-factor authentication device')
        ->call('hideRecoveryCodes')
        // Show disable 2FA confirmation modal
        ->call('showDisable2FAModal')
        ->assertSee('Input your password to disable the two-factor authentication method.')
        // Cancel disable 2FA
        ->call('cancelConfirmPassword')
        ->assertDontSee('Input your password to disable the two-factor authentication method.')
        ->assertDontSee('You have not enabled two factor authentication')
        // Try again
        ->call('showDisable2FAModal')
        ->assertSee('Input your password to disable the two-factor authentication method.')
        ->set('confirmedPassword', 'password')
        ->call('submitConfirmPassword')
        ->assertSee('You have not enabled two factor authentication');
});

it('cannot disable 2FA if password is not confirmed', function () {
    // Expecting exception
    $this->expectException(Exception::class);

    $user = createUserModel();

    $g2FA = $this->mock(Google2FA::class);
    $g2FA->shouldReceive('verifyKey')
        ->andReturnTrue();
    app()->instance('pragmarx.google2fa', $g2FA);

    $two_factor_secret = 'QHBRXHLWOT3B2T3L';
    Livewire::actingAs($user)
        ->test(TwoFactorAuthenticationForm::class)
        ->assertSee('You have not enabled two factor authentication.')
        ->set('state.two_factor_secret', $two_factor_secret)
        ->assertSet('enabled', false)
        ->assertSee($two_factor_secret)
        ->set('state.otp', '843733')
        ->call('enableTwoFactorAuthentication')
        ->assertSee('Two-Factor Authentication Recovery Codes')
        ->assertSee('If you lose your two-factor authentication device')
        ->call('hideRecoveryCodes')
        ->assertSee('You have enabled two factor authentication')
        ->call('showDisable2FAModal')
        ->assertSee('Input your password to disable the two-factor authentication method.')
        // Im not adding the `->set('confirmedPassword', 'password')` method here
        // so calling `submitConfirmPassword` should fail
        ->call('submitConfirmPassword')
        ->assertDontSee('You have not enabled two factor authentication');
});
