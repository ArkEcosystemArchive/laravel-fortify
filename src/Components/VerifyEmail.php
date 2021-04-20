<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Livewire\Component;

class VerifyEmail extends Component
{
    use WithRateLimiting;

    private const MAX_ATTEMPT = 1;
    private const DECAY_SECONDS = 5 * 60;

    private bool $limitReached = false;

    public function render(): View
    {
        return view('ark-fortify::components.auth-verify-email', [
            'limitReached' => $this->limitReached,
        ]);
    }

    public function resend(): void
    {
        try {
            $this->rateLimit(self::MAX_ATTEMPT, self::DECAY_SECONDS);

            $this->checkRateLimit();
        } catch (TooManyRequestsException $e) {
            return;
        }

        (new EmailVerificationNotificationController())->store(request());
    }

    public function checkRateLimit(): void
    {
        $this->limitReached =  RateLimiter::tooManyAttempts($this->getRateLimitKey('resend'), self::MAX_ATTEMPT);
    }
}
