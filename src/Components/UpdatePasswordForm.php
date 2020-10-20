<?php

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\Fortify\Components\Concerns\ValidatesPassword;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;
class UpdatePasswordForm extends Component
{
    use InteractsWithUser;
    use ValidatesPassword;

    protected $listeners = ['passwordUpdated' => 'passwordUpdated'];

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [
        'current_password'      => '',
        'password'              => '',
        'password_confirmation' => '',
    ];

    /**
     * Update the user's password.
     *
     * @param \Laravel\Fortify\Contracts\UpdatesUserPasswords $updater
     *
     * @return void
     */
    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();

        $updater->update(Auth::user(), $this->state);

        $this->state = [
            'current_password'      => '',
            'password'              => '',
            'password_confirmation' => '',
        ];

        $this->emit('saved');
    }

    public function updatedStatePassword($password)
    {
        $this->updatedPassword($password);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.update-password-form');
    }
}
