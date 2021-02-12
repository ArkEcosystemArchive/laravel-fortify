<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\DeleteUserForm;
use ARKEcosystem\Fortify\Contracts\DeleteUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
        ->assertSee(trans('fortify::pages.user-settings.delete_account_description'))
        ->set('usernameConfirmation', $user->username)
        ->call('deleteUser')
        ->assertRedirect(URL::signedRoute('profile.feedback'));
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
        ->assertSee(trans('fortify::pages.user-settings.delete_account_description'))
        ->call('deleteUser')
        ->set('usernameConfirmation', 'invalid-username')
        ->call('deleteUser');
    $this->assertNotNull(Auth::user());
});
