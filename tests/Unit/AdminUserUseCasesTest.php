<?php

namespace Tests\Unit;

use Src\Admin\User\Application\CreateUserUseCase;
use Src\Admin\User\Application\GetUserByIdUseCase;
use Src\Admin\User\Domain\Contracts\UserRepositoryInterface;
use Src\Admin\User\Domain\Entities\User;
use Src\Admin\User\Domain\ValueObjects\UserEmail;
use Src\Admin\User\Domain\ValueObjects\UserName;
use Tests\TestCase;

class AdminUserUseCasesTest extends TestCase
{
    public function test_create_user_use_case_saves_user_using_repository(): void
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (User $user) {
                return $user->id() === 123
                    && $user->name()->value() === 'alice'
                    && $user->email()->value() === 'alice@example.com';
            }));

        $useCase = new CreateUserUseCase($repository);
        $useCase->__invoke('alice', 'alice@example.com');
    }

    public function test_get_user_by_id_use_case_returns_user_from_repository(): void
    {
        $expectedUser = new User(123, new UserName('bob'), new UserEmail('bob@example.com'));

        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('find')
            ->with(123)
            ->willReturn($expectedUser);

        $useCase = new GetUserByIdUseCase($repository);
        $result = $useCase->__invoke(123);

        $this->assertSame($expectedUser, $result);
        $this->assertSame('bob', $result->name()->value());
        $this->assertSame('bob@example.com', $result->email()->value());
    }
}
