<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckGarageSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (auth()->check() && auth()->user()->user_type === 'Garage Owner') {
            if (!auth()->user()->hasActiveSubscription()) {
                // Redirect or abort
                return redirect()->route('plans.index')->with('error', 'Please subscribe to access features.');
            }
        }

        return $next($request);
    }
}
