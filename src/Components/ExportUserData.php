<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use Livewire\Component;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Illuminate\Support\Facades\RateLimiter;

class ExportUserData extends Component
{
    use InteractsWithUser;
    use WithRateLimiting;

    /**
     * Queue the export of the personal data for the authenticated user.
     *
     * @return void
     */
    public function export(): void
    {
        try {
            $this->rateLimit(1, 15 * 60);
        } catch (TooManyRequestsException $exception) {
            return;
        }

        dispatch(new CreatePersonalDataExportJob($this->user));

        flash()->success(trans('fortify::pages.user-settings.data_exported'));
    }

    public function rateLimitReached(): bool
    {
        return RateLimiter::tooManyAttempts($this->getRateLimitKey('export'), 1);
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
