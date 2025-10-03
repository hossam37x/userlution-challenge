<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the registration form.
     * @return View
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     *
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = $this->authService->register($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Your account has been created successfully! Welcome to our store.');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $remember = $request->remember ?? false;

        // Use the auth service to attempt login
        if ($this->authService->login($credentials, $remember, $request)) {
            $user = $this->authService->getAuthenticatedUser();

            return redirect()->intended(route('products.index'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput(['email' => $validated['email']]);
    }

    /**
     * Handle logout request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        // Use the auth service to logout
        $this->authService->logout($request);

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
