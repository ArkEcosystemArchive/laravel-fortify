<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Actions\AuthenticateUser;
use ARKEcosystem\Fortify\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

it('login the user by default username (email)', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    $user = User::factory()->create();

    $request = new Request();

    $request->replace([
        'email'    => $user->email,
        'password' => 'password',
    ]);

    $authenticator = new AuthenticateUser($request);
    $loggedUser = $authenticator->handle();

    $this->assertNotNull($loggedUser);
    $this->assertTrue($user->is($loggedUser));
});

it('login the user by the email when alt username is set', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);
    Config::set('fortify.username_alt', 'username');

    $user = User::factory()->withUsername()->create();

    $request = new Request();

    $request->replace([
        'email'    => $user->email,
        'password' => 'password',
    ]);

    $authenticator = new AuthenticateUser($request);
    $loggedUser = $authenticator->handle();

    $this->assertNotNull($loggedUser);
    $this->assertTrue($user->is($loggedUser));
});

it('login the user by the alt username (username)', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);
    Config::set('fortify.username_alt', 'username');

    $user = User::factory()->withUsername()->create();

    $request = new Request();

    $request->replace([
        'email'    => $user->username,
        'password' => 'password',
    ]);

    $authenticator = new AuthenticateUser($request);
    $loggedUser = $authenticator->handle();

    $this->assertNotNull($loggedUser);
    $this->assertTrue($user->is($loggedUser));
});

it('doesnt login the user by the alt username if not set (username)', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);
    Config::set('fortify.username_alt', null);

    $user = User::factory()->withUsername()->create();

    $request = new Request();

    $request->replace([
        'email'    => $user->username,
        'password' => 'password',
    ]);

    $authenticator = new AuthenticateUser($request);
    $loggedUser = $authenticator->handle();

    $this->assertNull($loggedUser);
});
