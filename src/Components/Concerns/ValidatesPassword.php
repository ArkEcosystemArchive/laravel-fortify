<?php

namespace ARKEcosystem\Fortify\Components\Concerns;

use ARKEcosystem\Fortify\Rules\Password;

trait ValidatesPassword
{
    public array $passwordRules = [
        'requireLowercase'        => false,
        'requireUppercase'        => false,
        'requireNumeric'          => false,
        'requireSpecialCharacter' => false,
        'isTooShort'              => false,
    ];

    public function updatedStatePassword($password)
    {
        $this->errorMessages = [];

        $passwordValidator = (new Password())
            ->length(12)
            ->requireLowercase()
            ->requireUppercase()
            ->requireNumeric()
            ->requireSpecialCharacter();

        foreach (array_keys($this->passwordRules) as $ruleName) {
            $this->passwordRules[$ruleName] = ! $passwordValidator->{$ruleName}($password);
        }
    }
}
