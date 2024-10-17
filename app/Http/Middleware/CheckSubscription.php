<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->hasActiveSubscription()) {
            return $next($request);
        }
        
        // Redirect to subscription page or show limited content
        return redirect()->route('subscription.index');
    }
}

