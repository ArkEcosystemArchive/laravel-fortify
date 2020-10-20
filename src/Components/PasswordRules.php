<?php

namespace ARKEcosystem\Fortify\Components;

use Illuminate\View\Component;

class PasswordRules extends Component
{
    public array $passwordRules;

    /**
     * Create the component instance.
     *
     * @param  array  $passwordRules
     * @return void
     */
    public function __construct(array $passwordRules)
    {
        $this->passwordRules = $passwordRules;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::auth.password-rules');
    }
}
