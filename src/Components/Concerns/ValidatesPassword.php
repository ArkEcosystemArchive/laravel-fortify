<?php

namespace ARKEcosystem\Fortify\Components\Concerns;

use Laravel\Fortify\Rules\Password;

trait ValidatesPassword
{
    public array $passwordRules = [
        'needsLowercase'        => false,
        'needsUppercase'        => false,
        'needsNumeric'          => false,
        'needsSpecialCharacter' => false,
        'isTooShort'            => false,
    ];

    public function updatedStatePassword($password)
    {
        $this->errorMessages = [];

        $passwordValidator = (new Password())
            ->length(12)
            ->requireUppercase()
            ->requireNumeric()
            ->requireSpecialCharacter();

        collect($this->passwordRules)
            ->each(function ($val, $ruleName) use ($passwordValidator, $password) {
                $this->passwordRules[$ruleName] = ! $passwordValidator->{$ruleName}($password);
            });
    }
}
