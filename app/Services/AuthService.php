<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Register a new user and log them in.
     *
     * @param array $userData
     * @return User
     */
    public function register(array $userData): User
    {
        // Create the user
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'age' => $userData['age'],
        ]);

        // Log the user in
        Auth::login($user);

        return $user;
    }

    /**
     * Attempt to log in a user with the given credentials.
     *
     * @param array $credentials
     * @param bool $remember
     * @param Request $request
     * @return bool
     */
    public function login(array $credentials, bool $remember = false, Request $request = null): bool
    {
        if (Auth::attempt($credentials, $remember)) {
            if ($request) {
                $request->session()->regenerate();
            }
            return true;
        }

        return false;
    }

    /**
     * Log out the current user and invalidate the session.
     *
     * @param Request|null $request
     * @return void
     */
    public function logout(Request $request = null): void
    {
        Auth::logout();

        if ($request) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }

    /**
     * Get the currently authenticated user.
     *
     * @return User|null
     */
    public function getAuthenticatedUser(): ?User
    {
        return Auth::user();
    }
}
