<?php

namespace ARKEcosystem\Fortify\Actions;

use ARKEcosystem\Fortify\Models;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $input)
    {
        $input = $this->buildValidator($input)->validate();

        return Models::user()::create($this->getUserData($input));
    }

    private function buildValidator(array $input): ValidationValidator
    {
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms'    => ['required', 'accepted'],
        ];

        if (Config::get('fortify.alt_username')) {
            $rules['username'] = ['required', 'string', 'max:255', 'unique:users'];
        }

        return Validator::make($input, $rules);
    }

    private function getUserData(array $input): array
    {
        $userData = [
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => Hash::make($input['password']),
        ];

        if (Config::get('fortify.alt_username')) {
            $userData['username'] = $input['username'];
        }

        return $userData;
    }
}
