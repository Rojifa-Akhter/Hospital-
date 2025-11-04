<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax()) {
            // Skip all further checks for AJAX requests and just proceed
            return $next($request);
        }
        if ($request->isMethod('post')) {
            return $next($request);  // Proceed to the next request for POST method
        }

        if ($request->isMethod('get') && $request->route() && ($request->route()->parameters() || $request->query())) {
            return $next($request);  // Allow GET requests with parameters or query parameters to pass through
        }
        // Get the current authenticated user
        $user = Auth::user();
        
        // If the user is not authenticated, abort with a 403 error
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Get the current URL path
        // $url = $request->path(); // E.g., /dashboard, /profile
        
        // $url=$request->route()->getName();


        $url = $request->path(); // Raw path, e.g., /dashboard

        // Try to find the route name by matching the URL path
        $routeName = null;
    
        // Loop through all defined routes to find a matching URL path
        foreach (Route::getRoutes() as $route) {
            if ($route->matches($request)) {
                $routeName = $route->getName();  // Get the route name if matched
                break;
            }
        }
        if (!$routeName) {
            abort(404, 'Route not found');
        }
        // dd( $routeName ,$url ,$user->id);    
        // Query the privileges table to check if the user has access to this URL
        $hasAccess = DB::table('wsec_userfeaturesprivs')
            ->join('wsec_menufeatures','wsec_menufeatures.features_no_pk','=','wsec_userfeaturesprivs.features_no_fk')
            ->where('wsec_userfeaturesprivs.user_no_fk', $user->user_no_pk)
            ->where('wsec_menufeatures.page_url', $routeName)
            ->exists(); // Return true if the user has the privilege for this URL

        // If no access, abort with a 403 error
        if (!$hasAccess) {
            abort(403, 'Unauthorized access to this resource');
        }

        // If access granted, proceed with the request
        return $next($request);
    }
}
