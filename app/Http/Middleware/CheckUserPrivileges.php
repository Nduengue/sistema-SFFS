<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckUserPrivileges
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Verifica se o status da conta do usuário é diferente de 1
        if (!$user || $user->account_status == 1) {
            return response()->json(['message' => 'Account is not active.'], 403); // Retorna erro 403 (Forbidden)
        }

        // Extrai o nome do recurso da URL (ex: 'users' de 'users/1')
        $resource = $this->extractResource($request->path());

        // Mapeia o método HTTP para o tipo de operação (ex: 'PUT' => 'update')
        $method = $this->mapMethodToOperation($request->method());

        // Verifica as permissões
        $privilegeStatus = $this->privileges($resource, $method, $user->privileges);

        if ($privilegeStatus === true) {
            // Usuário tem permissão, continua com a requisição
            return $next($request);
        }
        return response()->json(["message"=>'No Authorization for this Operation'], 403);
    }

    //Method to check If User has privilege to this operation
    public function privileges($ctl, $opr, $privileges){
        //$privileges = json_decode($getPrivileges, true);
        // Verifica se a linha ($ctl) está presente nas permissões do usuário e se é igual a 1
        if ($privileges[$ctl][$opr] == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Extrai o nome do recurso a partir da URL.
     *
     * @param string $path
     * @return string
     */
    protected function extractResource($path)
    {
        // Extrai o primeiro segmento da URL
        $segments = explode('/', $path);
        //return Str::camel($segments[1]); // Exemplo: 'users' -> 'users'
        return $segments[1]; // Exemplo: 'users' -> 'users'
    }

    /**
     * Mapeia o método HTTP para o tipo de operação.
     *
     * @param string $httpMethod
     * @return string
     */
    protected function mapMethodToOperation($httpMethod)
    {
        // Mapeia os métodos HTTP para as operações CRUD
        return match (strtoupper($httpMethod)) {
            'POST' => 'store',
            'PUT', 'PATCH' => 'put',
            'DELETE' => 'delete',
            default => 'get', // GET e outros são tratados como 'get'
        };
    }
}
