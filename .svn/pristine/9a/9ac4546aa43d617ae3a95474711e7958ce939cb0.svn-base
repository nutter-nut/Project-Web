<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RestrictAccessEmployee
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
        if(Auth::check()){
            if(Auth::user()->isAdmin() || Auth::user()->isEmployee() != '0'){
                return $next($request);
            }else{
                return redirect("/home")->with('fail', (\Session::get('locale') != "th") ? 'Not allowed.' : 'ไม่ได้รับอนุญาต');
            }
        }else{
            return redirect("/login");
        }
    }
}

