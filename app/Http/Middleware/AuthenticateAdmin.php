<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('admin_user')) {
            Session::put('url.intended', $request->url());
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return $next($request);
    }
}