<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle the login request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Flush any stored intended target URLs to prevent cross-role injection bugs
            session()->forget('url.intended');

            // Explicitly route users directly to their native environments
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang kembali, Admin ' . Auth::user()->name . '!');
            }

            return redirect()->route('masyarakat.dashboard')
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'masyarakat',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Registrasi berhasil. Selamat datang, Admin ' . $user->name . '!');
        }

        return redirect()->route('masyarakat.dashboard')
                ->with('success', 'Registrasi berhasil. Selamat datang, ' . $user->name . '!');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        // 1. Flush auth guards tokens
        Auth::logout();

        // 2. Invalidate the user's browser session completely
        $request->session()->invalidate();

        // 3. Regenerate the CSRF token security string to prevent session hijacking
        $request->session()->regenerateToken();

        // 4. Force direct redirection to the absolute landing welcome page
        return redirect('/');
    }
}
