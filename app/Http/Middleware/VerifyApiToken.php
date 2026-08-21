<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = config('app.api_bearer_token');

        if (!$expectedToken) {
            return response()->json(['error' => 'API Token no configurado en el servidor.'], 500);
        }

        $providedToken = $request->bearerToken();

        if ($providedToken !== $expectedToken) {
            return response()->json(['error' => 'No autorizado.'], 401);
        }

        return $next($request);
    }
}
