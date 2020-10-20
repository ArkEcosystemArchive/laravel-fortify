<?php

use ARKEcosystem\Fortify\Actions\CreateNewUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    $this->validPassword = 'Pas3w05d&123456';
});

it('should create a valid user with the create user action', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    $user = (new CreateNewUser)->create([
        'name' => 'Alfonso Bribiesca',
        'username' => 'alfonsobries',
        'email' => 'alfonso@ark.io',
        'password' => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms' => true
    ]);

    $this->assertEquals('alfonsobries', $user->username);
    $this->assertEquals('alfonso@ark.io', $user->email);
    $this->assertEquals('Alfonso Bribiesca', $user->name);
    $this->assertTrue(Hash::check($this->validPassword, $user->password));
});

it('should require a username', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'email' => 'alfonso@ark.io',
                'password' => $this->validPassword,
                'password_confirmation' => $this->validPassword,
                'terms' => true
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('username'));
    }
});

it('should require an email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'username' => 'alfonsobries',
                'password' => $this->validPassword,
                'password_confirmation' => $this->validPassword,
                'terms' => true
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('email'));
    }
});

it('should require a valid email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'username' => 'alfonsobries',
                'email' => 'alfonsobries',
                'password' => $this->validPassword,
                'password_confirmation' => $this->validPassword,
                'terms' => true
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('email'));
    }
});

it('should require the terms to be accepted', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'username' => 'alfonsobries',
                'email' => 'alfonso@ark.io',
                'password' => $this->validPassword,
                'password_confirmation' => $this->validPassword,
                'terms' => false
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('terms'));
    }
});

it('should match the confirmation', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'username' => 'alfonsobries',
                'email' => 'alfonso@ark.io',
                'password' => $this->validPassword,
                'password_confirmation' => 'password',
                'terms' => false
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('password'));
    }
});

it('should be equal to or longer than 12 characters', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'username' => 'alfonsobries',
                'email' => 'alfonso@ark.io',
                'password' => 'Sec$r2t',
                'password_confirmation' => 'Sec$r2t',
                'terms' => true
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('password'));
    }
});

it('should require an uppercase letter', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'username' => 'alfonsobries',
                'email' => 'alfonso@ark.io',
                'password' => 'sec$r2t12345',
                'password_confirmation' => 'sec$r2t12345',
                'terms' => true
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('password'));
    }
});

it('should require one number', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'username' => 'alfonsobries',
                'email' => 'alfonso@ark.io',
                'password' => 'sec$%Asfhhdfhfdhgd',
                'password_confirmation' => 'sec$%Asfhhdfhfdhgd',
                'terms' => true
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('password'));
    }
});

it('should require one special character', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)
            ->create([
                'name' => 'Alfonso Bribiesca',
                'username' => 'alfonsobries',
                'email' => 'alfonso@ark.io',
                'password' => 'sec23Asfhhdfhfdhgd',
                'password_confirmation' => 'sec23Asfhhdfhfdhgd',
                'terms' => true
            ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('password'));
    }
});
