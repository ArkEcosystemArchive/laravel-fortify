<?php

use ARKEcosystem\Fortify\Actions\CreateNewUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    $this->validPassword = 'Pas3w05d&123456';
});

it('creates a valid user with the create user action', function () {
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

it('requires an username', function () {
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

it('requires an email', function () {
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

it('requires a valid email', function () {
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

it('must accept terms', function () {
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

it('password must match', function () {
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

it('password must be 12 chars longer', function () {
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

it('password require an upercase letter', function () {
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

it('password require one number', function () {
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

it('password require one special character', function () {
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
