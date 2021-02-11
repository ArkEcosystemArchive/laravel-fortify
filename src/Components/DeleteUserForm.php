<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Contracts\DeleteUser;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasModal;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteUserForm extends Component
{
    use HasModal;

    public string $username;

    public string $usernameConfirmation = '';

    public function mount()
    {
        $this->username = Auth::user()->username;
    }

    public function confirmUserDeletion()
    {
        $this->dispatchBrowserEvent('confirming-delete-user');

        $this->openModal();
    }

    public function deleteUser(DeleteUser $deleter, StatefulGuard $auth)
    {
        if ($this->username === $this->usernameConfirmation) {
            $deleter->delete(Auth::user()->fresh());

            $auth->logout();

            return redirect('/feedback');
        }
    }

    public function render()
    {
        return view('ark-fortify::profile.delete-user-form');
    }
}
