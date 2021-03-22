<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Components\ExportUserData;
use Livewire\Livewire;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;

use function Tests\createUserModel;

it('can export the user data', function () {
    $this->expectsJobs(CreatePersonalDataExportJob::class);

    $instance = Livewire::actingAs(createUserModel())
        ->test(ExportUserData::class)
        ->call('export');

    $instance->assertEmitted('toastMessage', [trans('fortify::pages.user-settings.data_exported'), 'success']);
});
