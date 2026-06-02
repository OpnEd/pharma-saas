<?php

namespace Src\Admin\User\Infrastructure\Filament\Resources\Users\Pages;

use Filament\Resources\Pages\CreateRecord;
use Src\Admin\User\Infrastructure\Filament\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Src\Admin\User\Application\UseCases\CreateUserUseCase;
use Src\Admin\User\Application\Commands\CreateUserCommand;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    /**
     * Interceptamos la creación de Filament
     */
    protected function handleRecordCreation(array $data): Model
    {
        // 1. Construimos el Command (DTO) con los datos del formulario
        $command = new CreateUserCommand(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] // El Use Case se encargará de hashearlo
        );

        // 2. Ejecutamos el Caso de Uso de la Capa de Aplicación
        // El Caso de Uso instanciará la Entidad pura de Dominio y la pasará al Repositorio
        $useCase = app(CreateUserUseCase::class);

        $useCase->__invoke($command);

        // 3. El Compromiso con Filament:
        // Como Filament exige que devolvamos un Modelo de Eloquent para 
        // poder redirigir a la página de edición y mostrar la notificación de éxito,
        // lo consultamos en la base de datos usando la infraestructura.
        
        return User::where('email', $data['email'])->firstOrFail();
    }
}