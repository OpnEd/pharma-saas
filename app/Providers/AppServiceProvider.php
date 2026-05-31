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
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
