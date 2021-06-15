<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Actions\EnableTwoFactorAuthentication;
use ARKEcosystem\Fortify\Actions\GenerateTwoFactorAuthenticationSecretKey;
use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\Fortify\Rules\OneTimePassword;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasModal;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Livewire\Component;

class TwoFactorAuthenticationForm extends Component
{
    use InteractsWithUser;
    use HasModal;

    public bool $showingQrCode = false;

    public array $state = [];

    public bool $confirmPasswordShown = false;

    public string $confirmedPassword = '';

    public function mount(): void
    {
        if (! $this->enabled) {
            $this->generateSecretKey();
        }
    }

    public function render(): View
    {
        return view('ark-fortify::profile.two-factor-authentication-form');
    }

    public function enableTwoFactorAuthentication(): void
    {
        $this->validate([
            'state.otp' => ['required', new OneTimePassword($this->state['two_factor_secret']), 'digits:10'],
        ]);

        app(EnableTwoFactorAuthentication::class)(Auth::user(), $this->state['two_factor_secret']);

        $this->showingQrCode = true;
        $this->showRecoveryCodes();
    }

    public function showRecoveryCodes(): void
    {
        $this->openModal();
    }

    public function regenerateRecoveryCodes(): void
    {
        app(GenerateNewRecoveryCodes::class)(Auth::user());

        $this->showRecoveryCodes();
    }

    public function disableTwoFactorAuthentication(): void
    {
        app(DisableTwoFactorAuthentication::class)(Auth::user());

        $this->generateSecretKey();
    }

    public function getEnabledProperty(): bool
    {
        return ! empty($this->user->two_factor_secret);
    }

    public function getTwoFactorQrCodeSvgProperty(): string
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(192, 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
                new SvgImageBackEnd()
            )
        ))->writeString($this->twoFactorQrCodeUrl);

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }

    public function getTwoFactorQrCodeUrlProperty(): string
    {
        return app(TwoFactorAuthenticationProvider::class)->qrCodeUrl(
            config('app.name'),
            $this->user->email,
            $this->state['two_factor_secret']
        );
    }

    public function hideRecoveryCodes(): void
    {
        $this->closeModal();
    }

    private function generateSecretKey(): void
    {
        $this->state['two_factor_secret'] = app(GenerateTwoFactorAuthenticationSecretKey::class)();
    }

    public function showConfirmPassword(): void
    {
        $this->confirmPasswordShown = true;
    }

    public function closeConfirmPassword(): void
    {
        $this->confirmPasswordShown = false;

        $this->confirmedPassword = '';

        $this->modalClosed();
    }

    public function hasConfirmedPassword(): bool
    {
        return Hash::check($this->confirmedPassword, $this->user->password);
    }

    public function showRecoveryCodesAfterPasswordConfirmation(): void
    {
        $this->closeConfirmPassword();

        $this->showRecoveryCodes();
    }
}
