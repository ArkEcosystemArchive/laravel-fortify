<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\FooterEmailSubscriptionForm;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can render form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(FooterEmailSubscriptionForm::class)
        ->assertSet('subscribed', false)
        ->assertSet('email', null)
        ->assertSet('status', null)
        ->assertViewIs('ark-fortify::newsletter.footer-subscription-form');
});

it('can interact with the form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(FooterEmailSubscriptionForm::class)
        ->assertSet('subscribed', false)
        ->assertSet('email', null)
        ->assertSet('status', null)
        ->set('email', 'email@email.com')
        ->call('subscribe')
        ->assertViewIs('ark-fortify::newsletter.footer-subscription-form');
})->skip();
