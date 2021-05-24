<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (!Auth::check()) {
                return $view->with('user', null);
            }

            $user = User::with(['profile'])->findOrFail(Auth::id());
            $view->with('user', $user);
        });
    }
}
