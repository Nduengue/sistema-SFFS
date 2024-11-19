<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class VerifyStudentToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); // Obtém o token do cabeçalho da requisição
        //return response()->json([$token], 401);
        // Faz a requisição para o servidor de estudantes para verificar o token
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://127.0.0.1:8001/api/verify-token');

        // Verifica a resposta
        if ($response->successful() && $response->json()['valid']) {
            // O token é válido, continue a lógica
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized.'], 401);
    }
}
