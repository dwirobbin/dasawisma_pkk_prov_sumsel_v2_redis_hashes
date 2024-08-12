<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('pages.auth.passwords.forgot-password-create');
    }

    public function notice(Request $request)
    {
        return view('pages.auth.passwords.forgot-password-notice', ['email' => $request->string('email')]);
    }
}
