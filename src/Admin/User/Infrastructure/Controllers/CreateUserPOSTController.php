<?php

namespace Src\Admin\User\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Src\Admin\User\Application\Commands\CreateUserCommand;
use Src\Admin\User\Application\UseCases\CreateUserUseCase;
use Src\Admin\User\Domain\Contracts\UserRepositoryInterface;
use Src\Admin\User\Infrastructure\Validators\CreateUserRequest;

final class CreateUserPOSTController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(CreateUserRequest $request)
    {
        $command = new CreateUserCommand(
            name: $request->name,
            email: $request->email,
            password: $request->password ?? null
        );

        $createUserUseCase = new CreateUserUseCase($this->userRepository);

        $savedUser = $createUserUseCase->__invoke($command);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => [
                'id' => $savedUser->id()
            ]
        ], 201);
    }
}
