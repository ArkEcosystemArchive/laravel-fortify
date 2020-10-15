<?php

namespace Tests;

use ARKEcosystem\Fortify\FortifyServiceProvider;
use ARKEcosystem\UserInterface\UserInterfaceServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * @coversNothing
 */
class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            UserInterfaceServiceProvider::class,
            FortifyServiceProvider::class,
        ];
    }
}
