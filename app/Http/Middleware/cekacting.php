<?php

namespace App\Http\Middleware;

use Closure;

class cekacting
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->acting == 1) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
