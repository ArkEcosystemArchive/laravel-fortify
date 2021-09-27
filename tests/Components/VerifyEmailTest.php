<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Components\VerifyEmail;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can resend a verification email', function (): void {
    Livewire::actingAs(createUserModel())
        ->test(VerifyEmail::class)
        ->call('resend')
        ->assertDontSee(trans('fortify::messages.resend_email_verification_limit'));
});

it('can resend a verification email once every 5 minutes', function (): void {
    $component = Livewire::actingAs(createUserModel())
        ->test(VerifyEmail::class)
        ->call('resend')
        ->call('resend')
        ->assertSee(trans('fortify::messages.resend_email_verification_limit'));

    $this->travel(6)->minutes();

    $component->call('$refresh')->assertDontSee(trans('fortify::messages.resend_email_verification_limit'));
});
