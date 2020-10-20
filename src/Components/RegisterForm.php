<?php

namespace ARKEcosystem\Fortify\Components;

use Livewire\Component;
use ARKEcosystem\Fortify\Models;
use Domain\Collaborator\Models\Invitation;
use ARKEcosystem\Fortify\Components\Concerns\ValidatesPassword;

class RegisterForm extends Component
{
    use ValidatesPassword;
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;

    public string $formUrl;
    protected ?Invitation $invitation = null;

    public function mount()
    {
        $this->name = old('name', '');
        $this->username = old('username', '');
        $this->email = old('email', '');
        $this->terms = old('terms', '');

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
