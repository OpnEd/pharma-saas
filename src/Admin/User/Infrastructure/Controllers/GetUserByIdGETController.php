<?php

namespace Src\Admin\User\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Src\Admin\User\Application\UseCases\GetUserByIdUseCase;
use Src\Admin\User\Domain\Contracts\UserRepositoryInterface;

final class GetUserByIdGETController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index($id)
    {
        $getUserByIdUseCase = new GetUserByIdUseCase($this->userRepository);
        $user = $getUserByIdUseCase($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $user->id(),
                'name' => $user->name()->value(),
                'email' => $user->email()->value()
            ],
            'message' => 'User retrieved successfully'
        ]);
    }
}
