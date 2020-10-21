<?php

namespace ARKEcosystem\Fortify\Components\Concerns;

use ARKEcosystem\Fortify\Rules\Password;

trait ValidatesPassword
{
    public array $passwordRules = [
        'needsLowercase'        => false,
        'needsUppercase'        => false,
        'needsNumeric'          => false,
        'needsSpecialCharacter' => false,
        'needsMinimumLength'    => false,
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
