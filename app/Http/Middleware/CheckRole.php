<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }


        $user = Auth::user();

        if ($user->role !== $role) {
            switch ($user->role) {
                case 'laboran':
                    return redirect()->route('laboran')->with('not-access', 'Anda tidak memiliki akses untuk masuk kehalaman ini');;
                case 'mahasiswa':
                    return redirect()->route('mahasiswa')->with('not-access', 'Anda tidak memiliki akses untuk masuk kehalaman ini');;
                default:
                    return redirect()->route('unauthorized')->with('failed', 'Role tidak dikenali.');
            }
        }


        return $next($request);
    }
}
