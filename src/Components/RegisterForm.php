<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\ValidatesPassword;
use ARKEcosystem\Fortify\Models;
use Livewire\Component;

class RegisterForm extends Component
{
    use ValidatesPassword;

    public array $state = [
        'name'                  => '',
        'username'              => '',
        'email'                 => '',
        'password'              => '',
        'password_confirmation' => '',
        'terms'                 => false,
    ];

    public string $formUrl;

    public ?string $invitationId = null;

    public function mount()
    {
        $this->state = [
            'name'     => old('name', ''),
            'username' => old('username', ''),
            'email'    => old('email', ''),
            'terms'    => old('terms', ''),
        ];

        $this->formUrl = request()->fullUrl();

        $this->invitationId = request()->get('invitation');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::auth.register-form', [
            'invitation' => Models::invitation()::findByUuid($this->invitationId),
        ]);
    }
}
