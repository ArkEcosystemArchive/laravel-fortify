<?php

namespace ARKEcosystem\Fortify\Components;

use Livewire\Component;
use ARKEcosystem\Fortify\Models;
use ARKEcosystem\Fortify\Components\Concerns\ValidatesPassword;

class RegisterForm extends Component
{
    use ValidatesPassword;
    
    public array $state = [
        'name' => '',
        'username' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'terms' => false,
    ];

    public string $formUrl;

    protected $invitation = null;

    public function mount()
    {
        $this->state = [
            'name' => old('name', ''),
            'username' => old('username', ''),
            'email' => old('email', ''),
            'terms' => old('terms', ''),
        ];

        $this->formUrl = request()->fullUrl();

        if (request()->has('invitation')) {
            $this->invitation = Models::invitation()::findByUuid(request()->get('invitation'));
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::auth.register-form', [
            'invitation' => $this->invitation,
        ]);
    }
}
