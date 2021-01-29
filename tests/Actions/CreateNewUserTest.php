<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Actions\CreateNewUser;
use ARKEcosystem\Fortify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;
use function Tests\expectValidationError;

beforeEach(function () {
    $this->validPassword = 'Pas3w05d&123456';
});

it('should create a valid user with the create user action', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]);

    $this->assertSame('john@doe.com', $user->email);
    $this->assertSame('John Doe', $user->name);
    $this->assertTrue(Hash::check($this->validPassword, $user->password));
});

it('should create a valid user with username if the username_alt setting is set', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);
    Config::set('fortify.username_alt', 'username');

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]);

    $this->assertSame('john@doe.com', $user->email);
    $this->assertSame('alfonsobries', $user->username);
    $this->assertSame('John Doe', $user->name);
    $this->assertTrue(Hash::check($this->validPassword, $user->password));
});

it('should require a username if alt username is set', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    Config::set('fortify.username_alt', 'username');

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]), 'username', 'The username field is required.');
});

it('should require an email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]), 'email', 'The email field is required.');
});

it('should require a valid email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'alfonsobries',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]), 'email', 'The email must be a valid email address.');
});

it('should require the terms to be accepted', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => false,
    ]), 'terms', 'The terms must be accepted.');
});

it('should match the confirmation', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => 'password',
        'terms'                 => false,
    ]), 'password', 'The password confirmation does not match.');
});

it('should be equal to or longer than 12 characters', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => 'Sec$r2t',
        'password_confirmation' => 'Sec$r2t',
        'terms'                 => true,
    ]), 'password', 'The password must be at least 12 characters and contain at least one uppercase character, one number, and one special character.');
});

it('should require an uppercase letter', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => 'sec$r2t12345',
        'password_confirmation' => 'sec$r2t12345',
        'terms'                 => true,
    ]), 'password', 'The password must be at least 12 characters and contain at least one uppercase character, one number, and one special character.');
});

it('should require one number', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => 'sec$%Asfhhdfhfdhgd',
        'password_confirmation' => 'sec$%Asfhhdfhfdhgd',
        'terms'                 => true,
    ]), 'password', 'The password must be at least 12 characters and contain at least one uppercase character, one number, and one special character.');
});

it('should require one special character', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => 'sec23Asfhhdfhfdhgd',
        'password_confirmation' => 'sec23Asfhhdfhfdhgd',
        'terms'                 => true,
    ]), 'password', 'The password must be at least 12 characters and contain at least one uppercase character, one number, and one special character.');
});

it('handles the invitation parameter', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);
    Config::set('fortify.models.invitation', CreateNewUserTest::class);

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
        'invitation'            => 'uuid-uuid-uuid-uuid',
    ]);

    $invitation = Models::invitation()::findByUuid('uuid-uuid-uuid-uuid');

    $this->assertSame($user->id, $invitation->user_id);
});

/**
 * @coversNothing
 */
class CreateNewUserTest extends Model
{
    use HasUuid;

    public ?string $uuid = null;

    public ?int $user_id = null;

    protected $guarded = [];

    public static $model = null;

    public static function findByUuid(string $uuid): ?Model
    {
        if (self::$model) {
            return self::$model;
        }

        self::$model = new self(compact('uuid'));

        return self::$model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        $this->user_id = Arr::get($attributes, 'user_id', $this->user_id);
        $this->uuid    = Arr::get($attributes, 'uuid', $this->uuid);
    }
}
