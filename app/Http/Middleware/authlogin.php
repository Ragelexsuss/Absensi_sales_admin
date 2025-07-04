<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class authlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
        $user = Auth::user();
        if(!Auth::check()){
            return redirect()->route('login')->withErrors(['errorLogin'=> 'Anda Belum Login']);
        } if ($user && $user->t0_role->nama_role == $role) {
            return $next($request);

        }
        return redirect()->back()->withErrors(['error' => 'Anda Tidak Memiliki Hak Akses!']);
    }
}
