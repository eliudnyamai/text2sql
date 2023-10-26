<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LemonSqueezyCustomers;
use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!LemonSqueezyCustomers::where('billable_id', Auth::id())->exists()) {
            return $request->expectsJson()
            ? response()->json(['success' => false, 'code'=>1, 'message' => 'Not a customer'])
            : response()->json(['success' => false, 'code'=>1, 'message' => 'Not a customer']);
        } 
        return $next($request);
    }
}
