<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        switch ($guard)
        {
            case 'mahasiswa':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('mahasiswa.home');
                }
            break;

            case 'dosen':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('dosen.home');
                }
            break;

            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.home');
                }
            break;

            case 'wali':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('wali.home');
                }
            break;
        }
        return $next($request);
    }
}
