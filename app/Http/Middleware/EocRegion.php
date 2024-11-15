<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class EocRegion
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
        $user = Session::get('auth');
        if($user->level!='eoc_region')
        {
            return redirect('/login');
        }
        return $next($request);
    }
}
