<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;

use Auth;

use Closure;

class SetLanguage
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
        if (\Session::has('locale'))
        {
            if(Auth::check())
            {
                \App::setlocale(\Session::get('locale'));

                $get_locale = DB::connection('mongodb')->collection("users")->where('id', "=", Auth::user()->id*1)->first();

                $locale = ($get_locale != null) ? $get_locale['language'] : \Config::get('app.locale') ;
                
                \App::setLocale($locale);

                return $next($request);
            }
            else
            {
                \App::setlocale(\Session::get('locale'));
                
                return $next($request);
            }
        }


        // if(\Session::has('locale'))
        // {
        //     \App::setlocale(\Session::get('locale'));
        // }
        // return $next($request);
    }
}
