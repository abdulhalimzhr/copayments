<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth; // Import the Auth Facade
use App\DTO\LoginDTO;

class Login
{
    /**
     * @param LoginDTO $dto
     * 
     * @return array
     */
    public function authenticate(LoginDTO $dto): array
    {
        $credentials = $dto->toArray();

        if (Auth::attempt($credentials)) {
            return [
                'status' => true
            ];
        }

        return [
            'status' => false,
            'message' => 'Invalid credentials',
        ];
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return Auth::user();
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return Auth::check();
    }

    /**
     * 
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
