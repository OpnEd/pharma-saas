<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Aquí puedes enlazar tus interfaces con tus implementaciones (Dependency Injection)
        // Esto es clave en la Arquitectura Hexagonal
        $this->app->bind(
            \Src\Admin\User\Domain\Contracts\UserRepositoryInterface::class,
            \Src\Admin\User\Infrastructure\Repositories\EloquentUserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Si decides tener tus migraciones distribuidas por módulo, las registras aquí:
        $this->loadMigrationsFrom([
            base_path('src/Admin/User/Infrastructure/Persistence/Migrations'),
            // ... añade el resto de rutas de migraciones
        ]);
    }
}
