<?php

namespace App\Http\Middleware;

use App\Enums\Http;
use App\Helpers\MessageResponse;
use Closure;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response| Responsable
    {
        if ( !$request->expectsJson() && !$request->user()->is_admin) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Invalid credinitals');
        }
        return $next($request);
    }
}
