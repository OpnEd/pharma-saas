<?php

namespace Tests\Unit;

use Src\admin\user\application\CreateUserUseCase;
use Src\admin\user\application\GetUserByIdUseCase;
use Src\admin\user\domain\contracts\UserRepositoryInterface;
use Src\admin\user\domain\entities\User;
use Src\admin\user\domain\value_objects\UserEmail;
use Src\admin\user\domain\value_objects\UserName;
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
        $useCase->__invoke(123, 'alice', 'alice@example.com');
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
