<?php

namespace Src\admin\user\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Src\admin\user\application\CreateUserUseCase;
use Src\admin\user\domain\contracts\UserRepositoryInterface;
use Src\admin\user\infrastructure\validators\CreateUserRequest;

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
            $request->id,
            $request->username,
            $request->email
        );

        return response()->json([
            'status' => true,
            'message' => 'User created successfully'
        ], 201);
    }
}
