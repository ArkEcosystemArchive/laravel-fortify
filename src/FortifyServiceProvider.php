<?php

namespace ARKEcosystem\Fortify;

use ARKEcosystem\Fortify\Actions\CreateNewUser;
use ARKEcosystem\Fortify\Actions\ResetUserPassword;
use ARKEcosystem\Fortify\Actions\UpdateUserPassword;
use ARKEcosystem\Fortify\Actions\UpdateUserProfileInformation;
use ARKEcosystem\Fortify\Components\DeleteUserForm;
use ARKEcosystem\Fortify\Components\ExportUserData;
use ARKEcosystem\Fortify\Components\LogoutOtherBrowserSessionsForm;
use ARKEcosystem\Fortify\Components\TwoFactorAuthenticationForm;
use ARKEcosystem\Fortify\Components\UpdatePasswordForm;
use ARKEcosystem\Fortify\Components\UpdateProfileInformationForm;
use ARKEcosystem\Fortify\Components\UpdateProfilePhotoForm;
use ARKEcosystem\Fortify\Components\UpdateTimezoneForm;
use ARKEcosystem\Fortify\Responses\FailedTwoFactorLoginResponse;
use ARKEcosystem\Fortify\Responses\TwoFactorLoginResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse as FailedTwoFactorLoginResponseContract;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResponseBindings();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLoaders();

        $this->registerPublishers();

        $this->registerComponents();

        $this->registerActions();

        $this->registerViews();

        $this->registerAuthentication();
    }

    /**
     * Register the loaders.
     *
     * @return void
     */
    public function registerLoaders(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'fortify');
    }

    /**
     * Register the publishers.
     *
     * @return void
     */
    public function registerPublishers(): void
    {
        $this->publishes([
            __DIR__.'/../config/fortify.php' => config_path('fortify.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views/auth'     => resource_path('views/auth'),
            __DIR__.'/../resources/views/livewire' => resource_path('views/livewire'),
        ], 'views');
    }

    /**
     * Register the components.
     *
     * @return void
     */
    public function registerComponents(): void
    {
        Livewire::component('profile.delete-user-form', DeleteUserForm::class);
        Livewire::component('profile.export-user-data', ExportUserData::class);
        Livewire::component('profile.logout-other-browser-sessions-form', LogoutOtherBrowserSessionsForm::class);
        Livewire::component('profile.two-factor-authentication-form', TwoFactorAuthenticationForm::class);
        Livewire::component('profile.update-password-form', UpdatePasswordForm::class);
        Livewire::component('profile.update-profile-information-form', UpdateProfileInformationForm::class);
        Livewire::component('profile.update-profile-photo-form', UpdateProfilePhotoForm::class);
        Livewire::component('profile.update-timezone-form', UpdateTimezoneForm::class);
    }

    /**
     * Register the actions.
     *
     * @return void
     */
    public function registerActions(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }

    /**
     * Register the views.
     *
     * @return void
     */
    private function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ark-fortify');

        Fortify::loginView(function () {
            return view('ark-fortify::auth.login');
        });

        Fortify::twoFactorChallengeView(function ($request) {
            $request->session()->put([
                'login.idFailure' => $request->session()->get('login.id'),
            ]);

            return view('ark-fortify::auth.two-factor-challenge');
        });

        Fortify::registerView(function ($request) {
            $invitation = null;

            if ($request->has('invitation')) {
                $invitation = Models::invitation()::findByUuid($request->get('invitation'));
            }

            return view('ark-fortify::auth.register', [
                'formUrl'    => $request->fullUrl(),
                'invitation' => $invitation,
            ]);
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('ark-fortify::auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            $user = Models::user()::where('email', $request->get('email'))->firstOrFail();

            if ($user->two_factor_secret) {
                if (! $request->session()->get('errors')) {
                    $request->session()->put([
                        'login.idFailure' => $user->getKey(),
                        'login.id'        => $user->getKey(),
                        'login.remember'  => true,
                        'url.intended'    => route('account.settings.password'),
                    ]);

                    return redirect()->route('two-factor.login');
                }
            }

            return view('ark-fortify::auth.reset-password', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return view('ark-fortify::auth.verify-email');
        });

        Fortify::confirmPasswordView(function () {
            return view('ark-fortify::auth.confirm-password');
        });
    }

    /**
     * Register the authentication callbacks.
     *
     * @return void
     */
    private function registerAuthentication(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            try {
                $username = $request->get('email');

                if (\filter_var($username, \FILTER_VALIDATE_EMAIL)) {
                    $user = Models::user()::where('email', $username)->firstOrFail();
                } else {
                    $user = Models::user()::where('username', $username)->firstOrFail();
                }

                if ($user && Hash::check($request->password, $user->password)) {
                    $user->update(['last_login_at' => Carbon::now()]);

                    return $user;
                }
            } catch (\Throwable $th) {
                return;
            }
        });
    }

    /**
     * Register the response bindings.
     *
     * @return void
     */
    private function registerResponseBindings()
    {
        $this->app->singleton(
            FailedTwoFactorLoginResponseContract::class,
            FailedTwoFactorLoginResponse::class
        );

        $this->app->singleton(
            TwoFactorLoginResponseContract::class,
            TwoFactorLoginResponse::class
        );
    }
}
