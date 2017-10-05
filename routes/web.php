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
use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Ventas;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;



//---------------- PRUEBAS ------------------------------
Route::get('pruebas', function(){

     return view('prueba');
});
Route::get('imagenes', function(){

});

Route::post('pruebas', function(Request $request){
    $user = Sentinel::authenticate($request->all());
$solicitud = 1;
    $user->notify(new \App\Notifications\SolicitudEnProceso($solicitud));
        return 1;
});


//-------------- Creacion automatica de cosas para cuando se hace una migracion ----
Route::get('creacionAutomatica', function(){
    $user = Sentinel::registerAndActivate(array('usuario'=>'200', 'email'=>'1', 'password'=> '200'));
    $role = Sentinel::getRoleRepository()->createModel()->create([
        'name' => 'genio',
        'slug' => 'genio',
    ]);
    $role->permissions = ['organismos.crear' => true, 'organismos.visualizar' => true, 'organismos.editar' => true, 'organismos.borrar'=> true, 'socios.editar' => true, 'socios.visualizar' => true, 'socios.crear' => true, 'socios.borrar' => true];
    $role->save();
    $role->users()->attach($user);
    return $user;

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