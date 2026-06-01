<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\admin\user\domain\contracts\UserRepositoryInterface;
use Src\admin\user\infrastructure\repositories\EloquentUserRepository;

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
        //
    }
}
