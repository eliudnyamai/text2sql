<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\LemonSqueezyCustomers;

class IsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user=Auth::user();
if (!LemonSqueezyCustomers::where('billable_id', Auth::id())->exists()) {
    return $request->expectsJson()
    ? response()->json(['success' => false, 'code'=>1, 'message' => 'Not a customer'])
    : response()->json(['success' => false, 'code'=>1, 'message' => 'Not a customer']);
} 
        if (!$user->subscription()->hasVariant('136778')&&!$user->subscription()->hasVariant('141650')) {
            return $request->expectsJson()
                 ? response()->json(['success' => false, 'code'=>2, 'message' => 'Not subscribed'])
                 : response()->json(['success' => false, 'code'=>2, 'message' => 'Not subscribed']);
        }
        if ($user->subscription()->expired()) {
            return $request->expectsJson()
            ? response()->json(['success' => false, 'code'=>3, 'message' => 'Subscription Expired'])
            : response()->json(['success' => false, 'code'=>3, 'message' => 'Subscription Expired']);
        }
        if ($user->subscription()->unpaid()) {
            return $request->expectsJson() 
            ? response()->json(['success' => false, 'code'=>4, 'message' => 'Subscription Unpaid'])
            : response()->json(['success' => false, 'code'=>4, 'message' => 'Subscription Unpaid']);
        }
        
        if ($user->subscription()->onGracePeriod()||$user->subscribedToVariant('136778')||$user->subscribedToVariant('141650')) {
            return $next($request);
        }
       
    }
}
