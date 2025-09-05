<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Services\AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    protected AuthService $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    /**
     * showLoginForm
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('dashboard.auth.login');
    }

    /**
     * login
     *
     * @param  AdminLoginRequest $request
     * @return RedirectResponse
     */
    public function login(AdminLoginRequest $request): RedirectResponse
    {
        // validate the request
        $credentials = $request->only('email', 'password');

        // call auth service
        $user = $this->auth_service->attemptLogin($credentials,  1);

        // check if theres user or not
        if (!$user)
            return to_route('dashboard.auth.showLoginForm')->withErrors(['email' => 'Invalid credentials']);

        // make auth for this user
        Auth::attempt($credentials, true);

        // redirect to dashboard page
        return to_route('dashboard.welcome');
    }

    public function logout() {

        // make logout for the user
        Auth::guard('web')->logout();

        // redirect to login page
        return to_route('dashboard.auth.showLoginForm');
    }
}
