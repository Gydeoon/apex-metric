<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPremium
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_premium) {
            return redirect()->route('dashboard')->withErrors(['premium_error' => 'Fitur ini eksklusif untuk member Premium. Silakan tingkatkan akun Anda!']);
        }

        return $next($request);
    }
}