<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function loginViaToken(Request $request, string $username)
    {
        // Check if the URL is valid
        if (!$request->hasValidSignature()) {
            flash_message('Token kadaluarsa, Minta ulang tautan.', 'fail');
            return to_route('auth.login');
        }

        // Search the user
        $user = User::where('username', '=', $username)->first();

        // go to login when not exists
        if (!isset($user)) {
            flash_message('User tidak ditemukan. silahkan mendaftar terlebih dahulu.', 'fail');
            return to_route('auth.login');
        }

        // Authenticate the user
        Auth::login($user);

        // Redirect to homepage
        return to_route('home');
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();
        session()->flush();

        return to_route('auth.login');
    }
}
