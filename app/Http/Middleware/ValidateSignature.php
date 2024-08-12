<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class ValidateSignature extends Middleware
{
    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array|null  $args
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Routing\Exceptions\InvalidSignatureException
     */
    public function handle($request, Closure $next, ...$args)
    {
        $userId = $request->segment(3);

        if ($userId != auth()->id()) {
            if (Auth::check()) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            $user = User::query()->findOrFail((int) $userId);
            if (!$user) {
                return to_route('auth.login')->with('message', [
                    'text' => 'Anda harus masuk terlebih dahulu!',
                    'type' => 'danger'
                ]);
            }

            Auth::login($user);
        }

        if (!$request->user()->hasVerifiedEmail() && $request->hasValidSignature()) {
            $request->user()->markEmailAsVerified();

            return to_route('verification.verified');
        }

        if (!$request->hasValidSignature() && (!$request->user()->hasVerifiedEmail() || $request->user()->hasVerifiedEmail())) {
            return to_route('verification.invalid');
        }

        return $next($request);
    }
}
