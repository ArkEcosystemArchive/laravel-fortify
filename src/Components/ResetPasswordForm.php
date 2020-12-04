<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\ValidatesPassword;
use Livewire\Component;

class ResetPasswordForm extends Component
{
    use ValidatesPassword;

    public $token;

    public array $state = [
        'email'                 => '',
        'password'              => '',
        'password_confirmation' => '',
    ];

    public function mount()
    {
        $this->token          = request()->route('token');
        $this->state['email'] = old('email', request()->email);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::auth.reset-password-form');
    }
}
