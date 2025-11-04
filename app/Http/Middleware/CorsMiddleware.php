<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
    $response = $next($request);

    $headers = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => '*',
        'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization, X-Requested-With',
        'Access-Control-Allow-Credentials' => 'true',
    ];

    // For StreamedResponse and BinaryFileResponse and other Symfony responses:
    if ($response instanceof StreamedResponse || $response instanceof BinaryFileResponse) {
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        return $response;
    }

    // For regular Laravel responses:
    if (method_exists($response, 'header')) {
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }
        return $response;
    }

    // Fallback: if no header() or headers property
    return $response;
}


// public function handle($request, Closure $next) {
//         // return $next($request)
//         //   ->header('Access-Control-Allow-Origin', '*')
//         //   ->header('Access-Control-Allow-Methods', '*')
//         //   ->header('Access-Control-Allow-Headers',' Origin, Content-Type, Accept, Authorization, X-Request-With')
//         //   ->header('Access-Control-Allow-Credentials',' true');
//         $response = $next($request);

//         $headers = [
//             'Access-Control-Allow-Origin' => '*',
//             'Access-Control-Allow-Methods' => '*',
//             'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization, X-Requested-With',
//             'Access-Control-Allow-Credentials' => 'true',
//         ];

//           if ($response instanceof StreamedResponse) {
//             foreach ($headers as $key => $value) {
//                 $response->headers->set($key, $value);
//             }
//             return $response;
//         }

//         // For normal responses
//         foreach ($headers as $key => $value) {
//             $response->header($key, $value);
//         }

//         return $response;
//     }

}
