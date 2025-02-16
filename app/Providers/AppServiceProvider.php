<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            if (method_exists($notifiable, 'getEmailForPasswordReset') === false) {
                throw new \Exception('Method getEmailForPasswordReset does not exist');
            }

            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
