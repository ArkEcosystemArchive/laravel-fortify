<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\RegisterForm;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

it('can interact with the form', function () {
    Config::set('fortify.models.invitation', RegisterFormTest::class);
    Route::get('terms-of-service', function () {
        return view('');
    })->name('terms-of-service');
    Route::get('privacy-policy', function () {
        return view('');
    })->name('privacy-policy');

    $invitationUuid = Uuid::uuid();

    Livewire::withQueryParams(['invitation' => $invitationUuid])
        ->test(RegisterForm::class)
        ->set('name', 'John Doe')
        ->set('username', 'jdoe')
        ->set('email', 'jdoe@example.org')
        ->set('email', 'jdoe@example.org')
        ->assertViewIs('ark-fortify::auth.register-form')
        ->assertViewHas('invitation');
});

/**
 * @coversNothing
 */
class RegisterFormTest extends Model
{
    use HasUuid;

    public static function findByUuid(string $uuid): ?Model
    {
        return new self();
    }
}
