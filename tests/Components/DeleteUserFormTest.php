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
        ->assertSee('Are you sure you want to delete your account? Deleting your account is irreversible and all deleted data is unrecoverable')
        ->call('deleteUser')
        ->assertRedirect('/');
    $this->assertNull(Auth::user());
});
