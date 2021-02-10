<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\DeleteUserForm;
use ARKEcosystem\Fortify\Contracts\DeleteUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can interact with the form', function () {
    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee('After 30 days your account will be permanently deleted and become unrecoverable. To confirm this action, enter your username below.')
        ->set('usernameConfirmation', $user->username)
        ->call('deleteUser')
        ->assertRedirect('/feedback');
    $this->assertNull(Auth::user());
});

it('cant delete user without filling in the username', function () {
    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee('After 30 days your account will be permanently deleted and become unrecoverable. To confirm this action, enter your username below.')
        ->call('deleteUser')
        ->set('usernameConfirmation', 'invalid-username')
        ->call('deleteUser');
    $this->assertNotNull(Auth::user());
});
