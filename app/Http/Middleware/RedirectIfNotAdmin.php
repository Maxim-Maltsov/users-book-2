<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfNotAdmin
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
          
        if ( Auth::check() && Auth::user()->role != 'admin' ) {
            
            return redirect()->route('home')
                             ->with("message", ' Вы не являетесь администратором.')
                             ->with("message-type", "danger");
        }
    
        return $next($request);
    }
}
