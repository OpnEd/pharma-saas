<?php

namespace Src\Admin\User\Infrastructure;

use Filament\Contracts\Plugin;
use Filament\Panel;

class UserPlugin implements Plugin
{
    public function getId(): string
    {
        return 'admin-user'; // Un ID único para el módulo
    }

    public function register(Panel $panel): void
    {
        // El módulo se encarga de descubrir SUS PROPIOS recursos y páginas.
        // Usamos __DIR__ para que la ruta sea relativa a donde vive este archivo.
        $panel
            ->discoverResources(in: __DIR__ . '/Filament', for: 'Src\\Admin\\User\\Infrastructure\\Filament\\Resources')
            ->discoverPages(in: __DIR__ . '/Filament', for: 'Src\\Admin\\User\\Infrastructure\\Filament\\Pages')
            ->discoverWidgets(in: __DIR__ . '/Filament', for: 'Src\\Admin\\User\\Infrastructure\\Filament\\Widgets');
    }

    public function boot(Panel $panel): void
    {
        // Aquí puedes inyectar CSS/JS específico del módulo, 
        // o registrar ganchos (hooks) de renderizado .
    }

    // Método estático para instanciar el plugin fácilmente
    public static function make(): static
    {
        return app(static::class);
    }
}