<?php

namespace Src\Admin\User\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Src\Admin\User\Application\CreateUserUseCase;
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
        $createUserUseCase = new CreateUserUseCase($this->userRepository);

        $createUserUseCase->__invoke(
            $request->name,
            $request->email,
            $request->password ?? null
        );

        return response()->json([
            'status' => true,
            'message' => 'User created successfully'
        ], 201);
    }
}
