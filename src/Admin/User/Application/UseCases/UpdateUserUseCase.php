<?php

namespace Src\Admin\User\Application\UseCases;

use Src\Admin\User\Domain\Contracts\UserRepositoryInterface;
use Src\Admin\User\Domain\ValueObjects\UserEmail;
use InvalidArgumentException;
use Src\Admin\User\Application\Commands\UpdateUserCommand;

class UpdateUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UpdateUserCommand $command): \Src\Admin\User\Domain\Entities\User
    {
        // 1. Recuperar la Entidad pura desde la base de datos
        $user = $this->userRepository->find($command->id);

        if (!$user) {
            throw new InvalidArgumentException("El usuario especificado no existe.");
        }

        // 2. Instanciar el nuevo Value Object del correo
        $newEmail = new UserEmail($command->email);

        // 3. Actualizar la Entidad. 
        // Para esto, tu Entidad User debe tener un método como `updateProfile()`
        $user->updateProfile($command->name, $newEmail);

        // 4. Persistir los cambios y devolver la entidad persistida
        return $this->userRepository->save($user);
    }
}