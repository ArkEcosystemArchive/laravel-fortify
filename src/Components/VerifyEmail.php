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

    public function render(): View
    {
        return view('ark-fortify::components.auth-verify-email');
    }

    public function resend(): void
    {
        try {
            $this->rateLimit(1, 5 * 60);
        } catch (TooManyRequestsException $e) {
            return;
        }

        (new EmailVerificationNotificationController())->store(request());
    }

    public function rateLimitReached(): bool
    {
        return RateLimiter::tooManyAttempts($this->getRateLimitKey('resend'), 1);
    }
}
