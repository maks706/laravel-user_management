<?php

namespace App\Http\Middleware;
use App\User;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckRole
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
        //dd(Auth::id());
        
        
        if(Auth::user()->role!=1 && $request->id!=Auth::id()){
            return redirect('/users');
        }
        return $next($request);
    }
}
