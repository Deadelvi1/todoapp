<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user')) {
            return redirect('login')->withErrors(['msg' => 'Silakan login terlebih dahulu.']);
        }
        return $next($request);
    }
}