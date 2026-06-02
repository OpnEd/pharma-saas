<?php

namespace Src\Admin\User\Application\UseCases;

use Src\Admin\User\Application\Commands\CreateUserCommand;
use Src\Admin\User\Domain\Contracts\UserRepositoryInterface;
use Src\Admin\User\Domain\Entities\User;
use Src\Admin\User\Domain\ValueObjects\UserEmail;
use Src\Admin\User\Domain\ValueObjects\UserName;
use Src\Admin\User\Domain\ValueObjects\UserPassword;

class CreateUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $nameValueObject = new UserName($command->name);
        $emailValueObject = new UserEmail($command->email);
        $passwordValueObject = $command->password !== null ? new UserPassword($command->password) : null;

        $user = new User(
            null,
            $nameValueObject,
            $emailValueObject,
            $passwordValueObject
        );

        return $this->userRepository->save($user);
    }
}
