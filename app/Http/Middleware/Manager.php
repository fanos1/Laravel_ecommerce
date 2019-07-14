<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request); // Original

        // There are many ways to restrict access, but easier one is AUTH Facade
        if(!Auth::check()) {
            // if user NOT logged in
            return redirect('users/login');
        } else {
            $user = Auth::user();

            if($user->hasRole('manager')) {
                // if user is manager, pass. Grant access
                return $next($request);
            } else {
                // if user logged-in but Not manager, no access
                return redirect('/');
            }
        }

    }
}
