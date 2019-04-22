<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;

use Closure;

use App\Client;
use App\Application;

class BasicAuth
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
        $_usuario = $request->header('PHP_AUTH_USER');
        $_pass = $request->header('PHP_AUTH_PW');
//        $email = $_SERVER['API_USERNAME'];
//        $password = $_SERVER['API_PASSWORD'];
        $email = "admin";
        $password = "admin";

        if ($_usuario == $email && $_pass == $password)
        {
            $user = $email;

            return $next($request);
        }

        log::error('Error of Authentication BasicAuth method handle'.json_encode($request->all()));
        return response()->json(['error','Unauthorized, auth invalid'],401);
    }
}




