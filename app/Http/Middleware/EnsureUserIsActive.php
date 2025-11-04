<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = is_numeric($request->email) ? 'user_code' : 'email';

        $user = DB::table('wsec_user')
            ->where($key, $request->email)
            ->first();

        if ($user && $user->status != 1) {
            return redirect()->route('login')
                ->with('error', 'Your account is inactive. Contact IT for support.');
        }   

        return $next($request);
    }
}
