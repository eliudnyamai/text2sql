<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user(); // Assuming you're working with authenticated users
    
        if ($user->subscribedToVariant('136778')||$user->subscribedToVariant('141650')) {
            return redirect('/')->with('error', 'You Are Already Subscribed');
        }
    
        return $next($request);
    }
}