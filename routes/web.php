<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\Repositories\Eloquent\Cobranza\CobrarPorSocio;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Ventas;
use App\Operacion;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;



//---------------- PRUEBAS ------------------------------

Route::get('generarCuentasYDemas', function(){

   $proveedores = \App\Proovedores::all();
    if($proveedores->isNotEmpty()) {


        $primerProveedor = $proveedores->splice(1, 1);
        $primerProveedor = $primerProveedor->first();
        GeneradorDeCuentas::generar('Deudores ' . $primerProveedor->razon_social, '131010001');
        GeneradorDeCuentas::generar('Cta ' . $primerProveedor->razon_social, '311030001');
        GeneradorDeCuentas::generar('Comisiones ' . $primerProveedor->razon_social, '511030101');
        $proveedores->each(function ($proveedor) {
            $codigo = ImputacionGateway::obtenerCodigoNuevo('1310100');
            GeneradorDeCuentas::generar('Deudores ' . $proveedor->razon_social, $codigo);
            $codigo = ImputacionGateway::obtenerCodigoNuevo('3110300');
            GeneradorDeCuentas::generar('Cta ' . $proveedor->razon_social, $codigo);
            $codigo = ImputacionGateway::obtenerCodigoNuevo('5110301');
            GeneradorDeCuentas::generar('Comisiones ' . $proveedor->razon_social, $codigo);
        });
    }

});


Route::get('pruebas', function(){

     return view('prueba');
});
Route::get('prueba', function(){
    $operacion = Operacion::with('imputaciones')->find(1);
    $operacion->imputaciones->each(function($imputacion){

        if($imputacion->pivot->debe)
        {
            GeneradorDeAsientos::crear($imputacion->id, 200, 0, $imputacion->codigo);
        } else {
            GeneradorDeAsientos::crear($imputacion->id, 0, 200, $imputacion->codigo);
        }
    });});

Route::post('pruebas', function(Request $request){
    $user = Sentinel::authenticate($request->all());
$solicitud = 1;
    $user->notify(new \App\Notifications\SolicitudEnProceso($solicitud));
        return 1;
});

//-------------- ORGANISMOS -----------

Route::get('organismos/traerRelacionorganismos', 'ABM_organismos@traerRelacionorganismos');
Route::get('organismos/traerElementos', 'ABM_organismos@traerElementos');
Route::resource('organismos', 'ABM_organismos');

//--------------- SOCIOS -----------------------

Route::get('asociados/traerDatos', 'ABM_asociados@traerDatos');
Route::get('asociados/traerElementos', 'ABM_asociados@traerElementos');
Route::resource('asociados', 'ABM_asociados');

//---------------- PROVEEDORES ------------------------

Route::get('proovedores/datos', 'ABM_proovedores@datos');
Route::get('proovedores/traerElementos', 'ABM_proovedores@traerElementos');
Route::get('proovedores/traerRelacionproovedores', 'ABM_proovedores@traerRelacion');
Route::post('proveedores/productos', 'ABM_proovedores@productos');
Route::resource('proovedores', 'ABM_proovedores');

//---------------- PRODUCTOS ----------------

Route::post('productos/TraerProductos', 'ABM_productos@traerProductos');
Route::get('productos/traerElementos', 'ABM_productos@traerElementos');
Route::resource('productos', 'ABM_productos');

//---------------- PRIORIDADES -------------

Route::get('prioridades/traerRelacionprioridades', 'ABM_prioridades@traerRelacion');
Route::get('prioridades/datos', 'ABM_prioridades@datos');
Route::get('prioridades/traerElementos', 'ABM_prioridades@traerElementos');
Route::post('prioridades/guardarConfiguracion', 'ABM_prioridades@guardarConfiguracion');
Route::resource('prioridades', 'ABM_prioridades');

//-------------- ROLES --------------------

Route::get('roles/traerRelacionroles', 'ABM_roles@traerRelacionpantallas');
Route::get('roles/traerRoles', 'ABM_roles@traerRoles');
Route::resource('roles', 'ABM_roles');


//--------------- ABM COMERCIALIZADOR ---------------------

Route::get('abm_comercializador/comercializadores', 'ABM_Comercializador@comercializadores');
Route::resource('abm_comercializador', 'ABM_Comercializador');


//---------------- USUARIOS --------------------

Route::get('usuarios/traerElementos', 'ABM_usuarios@all');
Route::resource('usuarios', 'ABM_usuarios');

//-------------- APROBACION SERVICIOS -------------

Route::get('aprobacion', 'AprobacionServiciosController@index');
Route::get('aprobacion/datos', 'AprobacionServiciosController@datos');
Route::post('aprobacion/aprobar', 'AprobacionServiciosController@aprobarServicios');

//------------- DAR SERVICIO -------------------
Route::get('dar_servicio', 'Dar_Servicio@index');
Route::post('dar_servicio/filtroSocios', 'Dar_Servicio@sociosQueCumplenConFiltro');
Route::post('dar_servicio/filtroProovedores', 'Dar_Servicio@proovedoresQueCumplenConFiltro');

//------------ LOGIN ----------------------
Route::get('login', 'Login@index');
Route::get('logout', 'Login@logout');
Route::post('login', 'Login@login');

//-------------- VENTAS -------------------

Route::post('ventas/mostrarPorOrganismo', 'VentasControlador@mostrarPorOrganismo');
Route::post('ventas/datosAutocomplete', 'VentasControlador@traerDatosAutocomplete');
Route::post('ventas/saldo', 'VentasControlador@saldo');
Route::post('ventas/mostrarPorCuotas', 'VentasControlador@mostrarPorCuotas');
Route::post('ventas/mostrarPorVenta', 'VentasControlador@mostrarPorVenta');
Route::post('ventas/mostrarPorSocio', 'VentasControlador@mostrarPorSocio');
Route::post('ventas/cancelarVenta', 'VentasControlador@cancelarVenta');
Route::post('ventas/movimientos', 'VentasControlador@mostrarMovimientosVenta');

Route::resource('ventas', 'VentasControlador');

//-------------- COBRANZA --------------------

Route::get('cobranza', 'CobranzaController@index');
Route::post('cobranza/datos', 'CobranzaController@datos');
Route::post('cobranza/datosAutocomplete', 'CobranzaController@traerDatosAutocomplete');
Route::post('cobranza/porSocio', 'CobranzaController@mostrarPorSocio');

//-------------- PAGO PROVEEDORES -----------

Route::get('pago_proovedores', 'PagoProovedoresController@index');
Route::post('pago_proovedores/datos', 'PagoProovedoresController@datos');
Route::post('pago_proovedores/datosAutocomplete', 'PagoProovedoresController@traerDatosAutocomplete');
Route::post('pago_proovedores/pagarCuotas', 'PagoProovedoresController@pagarCuotas');
Route::post('pago_proovedores/detalleProveedor', 'PagoProovedoresController@detalleProveedor');

//----------------- COBRAR VENTAS ---------------

Route::post('cobrar/datos', 'CobrarController@datos');
Route::post('cobrar/datosAutocomplete', 'CobrarController@traerDatosAutocomplete');
Route::post('cobrar/cobrarCuotas', 'CobrarController@cobrarCuotas');
Route::post('cobrar/cobroPorPrioridad', 'CobrarController@cobrarPorPrioridad');
Route::post('cobrar/porSocio', 'CobrarController@mostrarPorSocio');
Route::post('cobrar/mostrarPorVenta', 'CobrarController@mostrarPorVenta');
Route::post('cobrar/cobroPorVenta', 'CobrarController@cobrarPorVenta');
Route::resource('cobrar', 'CobrarController');

//----------------- CC CUOTAS SOCIALES ----------------

Route::get('cc_cuotasSociales', 'CC_CuotasSocialesController@index');
Route::post('cc_cuotasSociales/mostrarOrganismos', 'CC_CuotasSocialesController@mostrarPorOrganismos');
Route::post('cc_cuotasSociales/mostrarSocios', 'CC_CuotasSocialesController@mostrarPorSocios');
Route::post('cc_cuotasSociales/mostrarCuotas', 'CC_CuotasSocialesController@mostrarPorCuotas');

//----------------- COBRO CUOTAS SOCIALES ----------------------

Route::get('cobroCuotasSociales', 'CobroCuotasSocialesController@index');
Route::post('cobroCuotasSociales/porOrganismo', 'CobroCuotasSocialesController@mostrarPorOrganismo');
Route::post('cobroCuotasSociales/porSocio', 'CobroCuotasSocialesController@mostrarPorSocio');
Route::post('cobroCuotasSociales/cobrar', 'CobroCuotasSocialesController@cobrar');

//------------------- COMERCIALIZADOR -----------------------

Route::get('comercializador', 'ComercializadorController@index');
Route::post('comercializador/altaSolicitud', 'ComercializadorController@altaSolicitud');
Route::get('comercializador/solicitudes', 'ComercializadorController@solicitudes');
Route::post('comercializador/aceptarPropuesta', 'ComercializadorController@aceptarPropuesta');
Route::post('comercializador/modificarPropuesta', 'ComercializadorController@modificarPropuesta');
Route::post('comercializador/enviarFormulario', 'ComercializadorController@enviarFormulario');
Route::post('comercializador/buscarSocios', 'ComercializadorController@sociosQueCumplenConFiltro');
Route::post('comercializador/fotos', 'ComercializadorController@fotos');

//------------------ SOLICITUDES PENDIENTES DE LA MUTUAL --------------

Route::get('solicitudesPendientesMutual', 'SolicitudesPendientesMutualController@index');
Route::post('solicitudesPendientesMutual/actualizar', 'SolicitudesPendientesMutualController@actualizar');
Route::get('solicitudesPendientesMutual/solicitudes', 'SolicitudesPendientesMutualController@solicitudes');
Route::get('solicitudesPendientesMutual/fotos', 'SolicitudesPendientesMutualController@fotos');
Route::post('solicitudesPendientesMutual/proveedores', 'SolicitudesPendientesMutualController@proveedores');
Route::post('solicitudesPendientesMutual/aprobarSolicitud', 'SolicitudesPendientesMutualController@aprobarSolicitud');
Route::get('solicitudesPendientesMutual/conCapitalOtrogado', 'SolicitudesPendientesMutualController@solicitudesAVerificar');

//------------------- SOLICITUDES DE AGENTE FINANCIERO -----------------------

Route::get('agente_financiero', 'AgenteFinancieroController@index');
Route::post('agente_financiero/enviarPropuesta', 'AgenteFinancieroController@generarPropuesta');
Route::get('agente_financiero/solicitudes', 'AgenteFinancieroController@solicitudes');
Route::post('agente_financiero/rechazarPropuesta', 'AgenteFinancieroController@rechazarPropuesta');
Route::post('agente_financiero/aceptarPropuesta', 'AgenteFinancieroController@aceptarPropuesta');
Route::post('agente_financiero/contraPropuesta', 'AgenteFinancieroController@generarPropuesta');
Route::post('agente_financiero/reservarCapital', 'AgenteFinancieroController@reservarCapital');
Route::post('agente_financiero/otorgarCapital', 'AgenteFinancieroController@otorgarCapital');
Route::post('agente_financiero/fotos', 'AgenteFinancieroController@fotos');
Route::post('agente_financiero/proveedores', 'AgenteFinancieroController@proveedores');

//------------------- CORRER VTO DE SERVICIOS ----------------------------

Route::get('correrVto', 'CorrerVtoServiciosController@index');
Route::post('correrVto/correrServicio', 'CorrerVtoServiciosController@correrVto');
Route::get('correrVto/servicios', 'CorrerVtoServiciosController@servicios');

//--------------------- Proveedor Cuenta Corriente --------------------

Route::get('proveedorCC', 'ProveedorCCController@index');
Route::post('proveedorCC/CCporOrganismo', 'ProveedorCCController@cuentaCorrientePorOrganismo');
Route::post('proveedorCC/CCporSocio', 'ProveedorCCController@cuentaCorrientePorSocio');
Route::post('proveedorCC/CCporVentas', 'ProveedorCCController@cuentaCorrientePorVentas');
Route::post('proveedorCC/CCporCuotas', 'ProveedorCCController@cuentaCorrientePorCuotas');

//-------------------- CAPITULO ----------------------------------

Route::get('capitulo/traerElementos', 'ABM_Capitulos@all');
Route::resource('capitulo', 'ABM_Capitulos');

//-------------------- DEPARTAMENTO ----------------------------------

Route::get('departamento/traerElementos', 'ABM_Departamento@all');
Route::resource('departamento', 'ABM_Departamento');

//-------------------- IMPUTACION ----------------------------------

Route::get('imputacion/traerElementos', 'ABM_Imputacion@all');
Route::resource('imputacion', 'ABM_Imputacion');

//-------------------- MONEDA ----------------------------------

Route::get('moneda/traerElementos', 'ABM_Moneda@all');
Route::resource('moneda', 'ABM_Moneda');

//-------------------- RUBRO ----------------------------------

Route::get('rubro/traerElementos', 'ABM_Rubros@all');
Route::resource('rubro', 'ABM_Rubros');

//-------------------- SUB RUBRO ----------------------------------

Route::get('subRubro/traerElementos', 'ABM_SubRubro@all');
Route::resource('subRubro', 'ABM_SubRubro');

//------------------- NOTIFICACIONES ------------------------------

Route::post('notificacion/marcarComoLeida', 'NotificacionController@marcarComoLeida');
Route::get('notificaciones', 'NotificacionController@notificaciones');
Route::get('notificacion/marcarTodasLeidas', 'NotificacionController@marcarTodasLeidas');

//-------------------- ASIENTOS ---------------------------------

Route::resource('asientos', 'AsientosController');

//-------------------- BANCOS ----------------------------------

Route::get('bancos/traerElementos', 'BancoController@all');
Route::resource('bancos', 'BancoController');

//------------------- Cobro contable --------------------------

Route::get('cobrar_contablemente', 'CobrarContablemente@index');
Route::get('cobrar_contablemente/traerProveedores', 'CobrarContablemente@traerProveedores');
Route::get('cobrar_contablemente/traerBancos', 'CobrarContablemente@traerBancos');
Route::post('cobrar_contablemente/cobrar', 'CobrarContablemente@cobrar');

//-------------------- FECHA CONTABLE ---------------------------

Route::post('fechaContable', 'FechaContableController@setearFechaContable');
Route::get('fechaContable/borrar', 'FechaContableController@cerrarFechaContable');

//------------------- MAYOR CONTABLE ------------------------

Route::get('mayorContable', 'MayorContableController@index');
Route::post('mayorContable', 'MayorContableController@reporte');

//----------------- PAGO CONTABLE -------------------------------

Route::get('pagoContableProveedor', 'PagoProveedorContable@index');
Route::get('pagoContableProveedor/proveedores', 'PagoProveedorContable@proveedoresImpagos');
Route::post('pagoContableProveedor/pagar', 'PagoProveedorContable@pagar');


//----------------- BALANCE ---------------------------------------

Route::get('balance', 'BalanceController@index');
Route::post('balance', 'BalanceController@reporte');

//----------------- CAJA -----------------------------------------

Route::post('caja/elementosFiltrados', 'CajaController@all');
Route::resource('caja', 'CajaController');

//------------------ OPERACIONES --------------------------------

Route::get('operaciones/traerElementos', 'ABM_Operaciones@all');
Route::resource('operaciones', 'ABM_Operaciones');


//------------------- Caja Operaciones --------------------------

Route::resource('cajaOperaciones', 'CajaOperacionesController');

//------------------ CHEQUERA --------------------------------

Route::post('chequera/traerElementos', 'ChequeraController@all');
Route::resource('chequera', 'ChequeraController');
