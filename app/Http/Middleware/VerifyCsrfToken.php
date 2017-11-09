<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'pruebas', 'pago_proovedores/detalleProveedor','pago_contable_proveedores/proveedores', 'mayorContable', '/notificaciones', 'organismos/*', 'productos/*'
    ];
}
