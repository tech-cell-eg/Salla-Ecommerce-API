<?php

namespace App\Services;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\TokenDTO;
use App\Exceptions\CustomExceptions;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function register(RegisterDTO $dto): User
    {
        return $this->userRepository->create($dto->toArray());
    }

    public function login(LoginDTO $dto): TokenDTO
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        // Authenticate the user for the current request
        Auth::login($user);
        $token = $user->createToken('auth_token')->plainTextToken;
        return new TokenDTO($token);
    }

    public function logout(User $user): void
    {
        try {
            // Revoke all tokens for the authenticated user
            $user->tokens()->delete();
        } catch (\Exception $e) {
            // Log the exception for investigation
            
            // Throw appropriate custom exception
            throw CustomExceptions::authorizationError('Failed to revoke access tokens');
        }

    }
}