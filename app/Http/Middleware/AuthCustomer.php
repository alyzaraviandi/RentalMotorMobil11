<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role === 'customer') {
            return $next($request);
        }
        return redirect()->route('loginCustomer.create');
    }
}
