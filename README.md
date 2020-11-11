# Laravel Fortify

<p align="center">
    <img src="./banner.png" />
</p>

> Authentication Scaffolding for Laravel. Powered by Laravel Fortify.

## Installation

1. Require with composer: `composer require arkecosystem/fortify`
2. Publish all the assets / views with `php artisan vendor:publish --provider="ARKEcosystem\Fortify\FortifyServiceProvider" --tag=config`.
3. Disable auto-discovery for all fortify packages. This step is required so that we can control the loading order of `laravel/fortify` and `arkecosystem/fortify`.

```json
"extra": {
    "laravel": {
        "dont-discover": ["arkecosystem/fortify", "laravel/fortify"]
    }
},
```

4. Register the service providers in this exact order. This will ensure that our package can overwrite any bindings that `laravel/fortify` created.

```php
Laravel\Fortify\FortifyServiceProvider::class,
ARKEcosystem\Fortify\FortifyServiceProvider::class,
```

5. Enable or disable the login/register with username or email by using the `username_alt` setting in the `config/fortify.php` file

```php
<?php

return [
    // ...
    'username_alt' => 'username',
    // Or set that setting to `null` so the user can only login/register with email:
    // 'username_alt' => null,
    // ...
];
```

**Note:** If you use the `username_alt` setting, you need to ensure that your users table has that column.

6. Register databags in your  that are used by the auth pages

```php
use Konceiver\DataBags\DataBag;

...

public function boot()
{
    ...

    $this->registerDataBags();
}

private function registerDataBags(): void
{
    DataBag::register('fortify-content', [
        'register' => [
            'pageTitle' => '',
            'title' => '',
            'description' => '',
        ],
        'login' => [
            'pageTitle' => '',
            'title' => '',
            'description' => '',
        ],
        'two-factor-challenge' => [
            'pageTitle' => '',
        ],
        'forgot-password' => [
            'pageTitle' => '',
        ],
        'reset-password' => [
            'pageTitle' => '',
        ],
        'verify-email' => [
            'pageTitle' => '',
        ],
        'confirm-password' => [
            'pageTitle' => '',
        ],
    ]);
}
```
