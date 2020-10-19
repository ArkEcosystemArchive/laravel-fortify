<?php

use ARKEcosystem\Fortify\Actions\CreateNewUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

it('creates a valid user with the create user action', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    $user = (new CreateNewUser)->create([
      'name' => 'Alfonso Bribiesca',
      'username' => 'alfonsobries',
      'email' => 'alfonso@ark.io',
      'password' => 'secret',
      'password_confirmation' => 'secret',
      'terms' => true,
    ]);

    $this->assertEquals('alfonsobries', $user->username);
    $this->assertEquals('alfonso@ark.io', $user->email);
    $this->assertEquals('Alfonso Bribiesca', $user->name);
    $this->assertTrue(Hash::check('secret', $user->password));
});

it('requires an username', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)->create([
        'name' => 'Alfonso Bribiesca',
        'email' => 'alfonso@ark.io',
        'password' => 'secret',
        'password_confirmation' => 'secret',
        'terms' => true,
        ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('username'));
    }
});

it('requires an email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)->create([
        'name' => 'Alfonso Bribiesca',
        'username' => 'alfonsobries',
        'password' => 'secret',
        'password_confirmation' => 'secret',
        'terms' => true,
        ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('email'));
    }
});

it('requires a valid email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)->create([
        'name' => 'Alfonso Bribiesca',
        'username' => 'alfonsobries',
        'email' => 'alfonsobries',
        'password' => 'secret',
        'password_confirmation' => 'secret',
        'terms' => true,
        ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('email'));
    }
});

it('must accept terms', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)->create([
          'name' => 'Alfonso Bribiesca',
          'username' => 'alfonsobries',
          'email' => 'alfonso@ark.io',
          'password' => 'secret',
          'password_confirmation' => 'secret',
          'terms' => false,
        ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('terms'));
    }
});

it('password must match', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    try {
        (new CreateNewUser)->create([
          'name' => 'Alfonso Bribiesca',
          'username' => 'alfonsobries',
          'email' => 'alfonso@ark.io',
          'password' => 'secret',
          'password_confirmation' => 'password',
          'terms' => false,
        ]);
    } catch (ValidationException $e) {
        $this->assertTrue($e->validator->errors()->has('password'));
    }
});
