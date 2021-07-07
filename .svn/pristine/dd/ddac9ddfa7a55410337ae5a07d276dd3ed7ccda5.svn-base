<?php

namespace App\Http\Middleware;

use Closure;

class CheckBanned
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
        if (auth()->check() && auth()->user()->banned_until && now()->lessThan(auth()->user()->banned_until)) {
            $banned_days = now()->diffInDays(auth()->user()->banned_until);
            auth()->logout();

            if ($banned_days > 14) {
                $message_en = 'Your account has been suspended. Please contact administrator.';
                $message_th = 'บัญชีของคุณถูกระงับ กรุณาติดต่อผู้ดูแลระบบ';
            } else {

                $message_en = 'Your account has been suspended for '.$banned_days.'day. Please contact administrator.';
                $message_th = 'บัญชีของคุณถูกระงับ '.$banned_days.'วัน กรุณาติดต่อผู้ดูแลระบบ';
            }

            return redirect()->route('login')->with('fail', (\Session::get('locale') != "th") ? $message_en : $message_th);
        }

        return $next($request);
    }
}
