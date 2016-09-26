<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;

class SentinelAdmin
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

        if(!Sentinel::check())
            return Redirect::to('admin/signin')->with('error', 'You must be logged in!');
        // elseif(Sentinel::inRole('invoice'))
        //     return Redirect::to('admin/order/quickinvoice');
        // elseif(Sentinel::inRole('delivery'))
        //     return Redirect::to('admin/order');

        elseif(!Sentinel::inRole('admin') && !Sentinel::inRole('invoice') && !Sentinel::inRole('delivery') )
            return Redirect::to('my-account');


        return $next($request);
    }
}
