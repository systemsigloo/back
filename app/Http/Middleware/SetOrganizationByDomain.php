<?php

namespace App\Http\Middleware;

use App\Models\Org;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetOrganizationByDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Obtener el dominio de la solicitud
        $domain = $request->getHost(); // Equivalente a $_SERVER['HTTP_HOST']

        // Buscar la organización por el dominio
        $org = Org::where('domain', $domain)->first();

        if ($org) {
            // Almacenar el ID de la organización en la configuración
            config(['app.org_id' => $org->id]);
            config(['app.email' => $org->email]);
        } else {
            // Opcional: Manejar el caso donde no se encuentra la organización
            config(['app.org_id' => null]);
            // Puedes decidir abortar la solicitud o permitir que continúe
            // Ejemplo: abort(403, 'Organización no encontrada para el dominio: ' . $domain);
        }

        return $next($request);
    }
}
