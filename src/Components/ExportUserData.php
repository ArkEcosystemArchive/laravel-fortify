<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use Livewire\Component;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;

class ExportUserData extends Component
{
    use InteractsWithUser;

    /**
     * Queue the export of the personal data for the authenticated user.
     *
     * @return void
     */
    public function export(): void
    {
        dispatch(new CreatePersonalDataExportJob($this->user));

        $this->emit('toastMessage', [trans('fortify::pages.user-settings.data_exported'), 'success']);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.export-user-data');
    }
}
