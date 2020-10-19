<?php

namespace Tests;

use ARKEcosystem\Fortify\Models\User;
use Illuminate\Support\Str;

function createUserModel()
{
    return User::create([
        'name'              => 'John Doe',
        'username'             => 'john.doe',
        'email'             => 'john@doe.com',
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
        'timezone'          => 'UTC',
    ]);
}
