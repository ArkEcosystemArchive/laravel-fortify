<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\ValidatesPassword;
use Livewire\Component;
use ARKEcosystem\Fortify\Models;

class ResetPasswordForm extends Component
{
    use ValidatesPassword;

    public $token;
    public ?string $twoFactorSecret;

    public array $state = [
        'email'                 => '',
        'password'              => '',
        'password_confirmation' => '',
    ];

    public function mount(?string $token = null, ?string $email = null)
    {
        $this->token = $token;

        if ($email !== null) {
            $this->state['email'] = $email;

            $user = Models::user()::where('email', $email)->firstOrFail();

            $this->twoFactorSecret = $user->two_factor_secret;
        }
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
