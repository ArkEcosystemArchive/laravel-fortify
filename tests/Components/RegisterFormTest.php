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

it('can register if all validations ok', function () {
    Config::set('fortify.models.invitation', RegisterFormTest::class);
    Route::get('terms-of-service', function () {
        return view('');
    })->name('terms-of-service');
    Route::get('privacy-policy', function () {
        return view('');
    })->name('privacy-policy');
    Route::get('notification-settings', function () {
        return view('');
    })->name('notification-settings');

    $invitationUuid = Uuid::uuid();

    Livewire::withQueryParams(['invitation' => $invitationUuid])
        ->test(RegisterForm::class)
        ->set('state.name', 'John Doe')
        ->set('state.username', 'jdoe')
        ->set('state.email', 'jdoe@example.org')
        ->set('state.email', 'jdoe@example.org')
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
