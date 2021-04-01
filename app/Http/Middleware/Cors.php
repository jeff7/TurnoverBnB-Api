<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        header('Access-Control-Allow-Origin:  https://turnoverbnb.herokuapp.com');
        header('Access-Control-Allow-Headers:  Content-Type, *');
        header('Access-Control-Allow-Methods:  POST, PUT, DELETE, OPTIONS ');

        return $next($request);
    }
}
