<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Actions\EnableTwoFactorAuthentication;
use ARKEcosystem\Fortify\Actions\GenerateTwoFactorAuthenticationSecretKey;
use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\Fortify\Rules\OneTimePassword;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Livewire\Component;

class TwoFactorAuthenticationForm extends Component
{
    use InteractsWithUser;

    /**
     * Indicates if two factor authentication QR code is being displayed.
     *
     * @var bool
     */
    public $showingQrCode = false;

    /**
     * Indicates if two factor authentication recovery codes are being displayed.
     *
     * @var bool
     */
    public $showingRecoveryCodes = false;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount(): void
    {
        if (! $this->enabled) {
            $this->generateSecretKey();
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.two-factor-authentication-form');
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @param \ARKEcosystem\Fortify\Actions\EnableTwoFactorAuthentication $enable
     *
     * @return void
     */
    public function enableTwoFactorAuthentication()
    {
        $this->validate([
            'state.otp' => ['required', new OneTimePassword($this->state['two_factor_secret'])],
        ]);

        app(EnableTwoFactorAuthentication::class)(Auth::user(), $this->state['two_factor_secret']);

        $this->showingQrCode        = true;
        $this->showingRecoveryCodes = true;
    }

    /**
     * Display the user's recovery codes.
     *
     * @return void
     */
    public function showRecoveryCodes()
    {
        $this->showingRecoveryCodes = true;
    }

    /**
     * Generate new recovery codes for the user.
     *
     * @return void
     */
    public function regenerateRecoveryCodes()
    {
        app(GenerateNewRecoveryCodes::class)(Auth::user());

        $this->showingRecoveryCodes = true;
    }

    /**
     * Disable two factor authentication for the user.
     *
     * @return void
     */
    public function disableTwoFactorAuthentication()
    {
        app(DisableTwoFactorAuthentication::class)(Auth::user());

        $this->generateSecretKey();
    }

    /**
     * Determine if two factor authentication is enabled.
     *
     * @return bool
     */
    public function getEnabledProperty()
    {
        return ! empty($this->user->two_factor_secret);
    }

    /**
     * Get the QR code SVG of the user's two factor authentication QR code URL.
     *
     * @return string
     */
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

    /**
     * Get the two factor authentication QR code URL.
     *
     * @return string
     */
    public function getTwoFactorQrCodeUrlProperty(): string
    {
        return app(TwoFactorAuthenticationProvider::class)->qrCodeUrl(
            config('app.name'),
            $this->user->email,
            $this->state['two_factor_secret']
        );
    }

    /**
     * Hide the user's recovery codes.
     *
     * @return void
     */
    public function hideRecoveryCodes()
    {
        $this->showingRecoveryCodes = false;
    }

    /**
     * Generate the Two-Factor Authentication Secret Key.
     *
     * @return void
     */
    private function generateSecretKey(): void
    {
        $this->state['two_factor_secret'] = app(GenerateTwoFactorAuthenticationSecretKey::class)();
    }
}
