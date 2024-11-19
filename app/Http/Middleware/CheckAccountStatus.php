<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        /* $user = Auth::user();

        // Verifica se o status da conta do usuário é diferente de 1
        if ($user && $user->status !== 1) {
            return response()->json(['message' => 'Account is not active.'], 403); // Retorna erro 403 (Forbidden)
        }
 */
        return $next($request);
    }
}
