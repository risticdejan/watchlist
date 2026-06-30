<?php

namespace App\Http\Controllers\Api\Auth;

use App\Dtos\Auth\LoginDto;
use App\Dtos\Auth\RegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;


class AuthController extends Controller
{

    public function __construct(
        private UserService $userService
    ) {}

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $token = $this->userService->registerUser(RegisterDto::apply($validated));

        return response()->json(
            data: [
                'message' => 'Registered successfully',
                'token' => $token,
            ],
            status: 201
        );
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $token = $this->userService->login(LoginDto::apply($validated));

        if (! $token) {
            return response()->json(
                data: [
                    'message' => 'Registered successfully',
                    'token' => $token
                ],
                status: 422
            );
        }

        return response()->json(
            data: [
                'message' => 'Logged in',
                'token' => $token,
            ],
            status: 200
        );
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $this->userService->logout($user);
        }

        return response()->json(
            data: [
                'message' => 'Logged out',
            ],
            status: 200
        );
    }
}
