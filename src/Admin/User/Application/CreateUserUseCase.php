<?php

namespace Src\Admin\User\Application;

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

    public function __invoke(string $name, string $email, ?string $password = null): void
    {
        $nameValueObject = new UserName($name);
        $emailValueObject = new UserEmail($email);
        $passwordValueObject = $password !== null ? new UserPassword($password) : null;

        $user = new User(
            null,
            $nameValueObject,
            $emailValueObject,
            $passwordValueObject
        );

        $this->userRepository->save($user);
    }
}
