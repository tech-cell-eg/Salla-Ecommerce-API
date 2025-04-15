<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\TokenResource;
use App\Http\Resources\Auth\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    public function __construct(private AuthService $authService) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = RegisterDTO::fromRequest($request->validated());
        $user = $this->authService->register($dto);

     

        return ApiController::successResponse([
            "data"=>new UserResource($user),
            'message' => 'User registered successfully'
        ],201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        
        $dto = LoginDTO::fromRequest($request->validated());
        $tokenDTO = $this->authService->login($dto);
      
        return response()->json([
            'user' => new UserResource(Auth::user()),
            'token' => new TokenResource($tokenDTO)
        ]);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout(auth()->user());
       

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}