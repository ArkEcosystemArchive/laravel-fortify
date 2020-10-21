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

5. Add a `last_login_at` timestamp to your users table.

```php
    // php artisan make:migration add_last_login_at_to_users_table
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login_at');
        });
    }
```

6. Enable or disable the login/register with username or email by using the `alt_username` setting in the `config/fortify.php` file

```php
<?php

return [
    // ...
    'alt_username' => 'username',
    // Or set that setting to `null` so the user can only login/register with email:
    // 'alt_username' => null,
    // ...
];
```

**Note:** If you use the `alt_username` setting, you need to ensure that your users table has that column.

