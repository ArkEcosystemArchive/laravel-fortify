<?php

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Actions\PasswordValidationRules;
use Livewire\Component;
use Laravel\Fortify\Rules\Password;

class PasswordValidator extends Component
{
    use PasswordValidationRules;

    /**
     * The component's state.
     *
     * @var array
     */
    public $password;

    public $rules = [
        'needsLowercase' => false,
        'needsUppercase' => false,
        'needsANumber' => false,
        'needsSpecialCharacter' => false,
        'isTooShort' => false,
    ];

    public function updatedPassword($password)
    {
        $passwordValidator = (new Password())
            ->length(12)
            ->requireUppercase()->requireNumeric()->requireSpecialCharacter();

        collect($this->rules)->each(function ($val, $ruleName) use ($passwordValidator, $password) {
            $this->rules[$ruleName] = ! $passwordValidator->{$ruleName}($password);
        });
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::auth.password-validator');
    }
}
