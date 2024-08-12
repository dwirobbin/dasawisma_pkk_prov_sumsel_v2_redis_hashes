<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function create(Request $request)
    {
        $pwdResetToken = DB::table('password_reset_tokens')
            ->where('email', $request->get('email'))
            ->first();

        if (!$pwdResetToken) {
            session()->flash('message', [
                'text' => 'Token telah hangus, kirim ulang tautan reset kata sandi!',
                'type' => 'danger'
            ]);

            return to_route('password.request');
        }

        $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $pwdResetToken->created_at)->diffInMinutes(Carbon::now());

        if ($diffMins > config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')) {
            session()->flash('message', [
                'text' => 'Token kadaluarsa, kirim ulang tautan reset kata sandi!',
                'type' => 'danger'
            ]);

            return to_route('password.request');
        }

        if ($request->get('email') != $pwdResetToken->email && !Hash::check($request->segment(3), $pwdResetToken->token)) {
            session()->flash('message', [
                'text' => 'Token tidak valid, kirim ulang tautan reset kata sandi!',
                'type' => 'danger'
            ]);

            return to_route('password.request');
        }

        return view('pages.auth.passwords.reset-password-create', [
            'token' => $request->segment(3),
            'email' => $request->string('email'),
        ]);
    }

    public function invalid()
    {
        return view('pages.auth.passwords.reset-password-invalid');
    }
}
