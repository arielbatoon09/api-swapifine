<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /*
        * To set the JWT Token inside the backend server
    */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            if ($jwt = $request->cookie('jwt')) {
                $request->headers->set('Authorization', 'Bearer ' . $jwt);
            } else {
                return response([
                    'status' => 'error',
                    'message' => "Can't find account token!",
                ]);
            }
            $this->authenticate($request, $guards);
    
            return $next($request);
        } catch (Throwable $e) {
            Log::error('Error in Authenticate middleware: ' . $e->getMessage());
            
            return response([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }
}
