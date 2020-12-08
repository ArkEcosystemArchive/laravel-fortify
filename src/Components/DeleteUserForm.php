<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\StatefulGuard;
use ARKEcosystem\Fortify\Contracts\DeleteUser;

class DeleteUserForm extends Component
{
    /**
     * Indicates if user deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingUserDeletion = false;

    /**
     * Confirm that the user would like to delete their account.
     *
     * @return void
     */
    public function confirmUserDeletion()
    {
        $this->dispatchBrowserEvent('confirming-delete-user');

        $this->confirmingUserDeletion = true;
    }

    /**
     * Delete the current user.
     *
     * @param \ARKEcosystem\Fortify\Contracts $deleter
     * @param \Illuminate\Contracts\Auth\StatefulGuard $auth
     *
     * @return void
     */
    public function deleteUser(DeleteUser $deleter, StatefulGuard $auth)
    {
        resolve(DeleteUser::class)->delete(Auth::user()->fresh());

        $auth->logout();

        return redirect('/');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.delete-user-form');
    }
}
