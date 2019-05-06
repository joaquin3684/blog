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


use App\ConfigImputaciones;
use App\Cuotas;
use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\ProveedorImputacionDeudores;
use App\Repositories\Eloquent\Cobranza\CobrarPorSocio;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\FileManager;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Ventas;
use App\Operacion;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;



Route::get('generarCuotasSociales', function(){

    DB::transaction(function () {
        $fechaInicioCuota = Carbon::today()->toDateString();
        $fechaVencimientoCuota = Carbon::today()->addMonths(2);
        $socios = \App\Socios::all();
        $socios->each(function ($socio) use($fechaInicioCuota, $fechaVencimientoCuota){
            $cuota = Cuotas::create([
                'fecha_inicio' => $fechaInicioCuota,
                'fecha_vencimiento' => $fechaVencimientoCuota,
                'importe' => $socio->valor,
                'nro_cuota' => 1,
            ]);
         /*   $impu = ImputacionGateway::buscarPorCodigo('511010101');
            GeneradorDeAsientos::crear($impu, 0, $socio->valor);
            GeneradorDeAsientos::crear($impu, $socio->valor, 0);*/
            $socio->cuotasSociales()->save($cuota);
        });

    });
});

Route::get('/', function(){
   return view('landing');
});

//---------------- PRUEBAS ------------------------------

Route::get('generarCuentasYDemas', function(){

   $proveedores = \App\Proovedores::all();
    if($proveedores->isNotEmpty()) {


        $primerProveedor = $proveedores->splice(1, 1);
        $primerProveedor = $primerProveedor->first();
        $codigoBase = ConfigImputaciones::find(1);
        $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
        $imputacion = GeneradorDeCuentas::generar('Deudores '.$primerProveedor->razon_social, $codigo);
        ProveedorImputacionDeudores::create(['id_proveedor' => $primerProveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Deudores', 'codigo' => $imputacion->codigo]);
        $codigoBase = ConfigImputaciones::find(2);
        $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
        $imputacion = GeneradorDeCuentas::generar('Cta '.$primerProveedor->razon_social, $codigo);
        ProveedorImputacionDeudores::create(['id_proveedor' => $primerProveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Cta', 'codigo' => $imputacion->codigo]);
        $codigoBase = ConfigImputaciones::find(3);
        $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
        $imputacion = GeneradorDeCuentas::generar('Comisiones '.$primerProveedor->razon_social, $codigo);
        ProveedorImputacionDeudores::create(['id_proveedor' => $primerProveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Comisiones', 'codigo' => $imputacion->codigo]);


        $proveedores->each(function ($proveedor) {
            $codigoBase = ConfigImputaciones::find(1);
            $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
            $imputacion = GeneradorDeCuentas::generar('Deudores '.$proveedor->razon_social, $codigo);
            ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Deudores', 'codigo' => $imputacion->codigo]);
            $codigoBase = ConfigImputaciones::find(2);
            $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
            $imputacion = GeneradorDeCuentas::generar('Cta '.$proveedor->razon_social, $codigo);
            ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Cta', 'codigo' => $imputacion->codigo]);
            $codigoBase = ConfigImputaciones::find(3);
            $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
            $imputacion = GeneradorDeCuentas::generar('Comisiones '.$proveedor->razon_social, $codigo);
            ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Comisiones', 'codigo' => $imputacion->codigo]);


        });
    }

});


Route::get('pruebas', function(){

     return view('prueba');
});
Route::get('nombreSocios', function(){
    DB::transaction(function(){


   $socios = \App\Socios::all();
   $socios->each(function($socio){
       $socio->nombre = $socio->apellido.', '.$socio->nombre;
       $socio->save();
   });
    });
});


Route::get('prueba', function(){
    DB::transaction(function(){


    $ventas = \App\Ventas::all();
    $ventas->each(functioN($venta){
        \App\EstadoVenta::create(['id_venta' => $venta->id, 'id_responsable_estado' => 1, 'estado' => 'APROBADO']);
    });
    $cuotas = \App\Cuotas::all();
    $cuotas->each(function($cuota){
        $venta = Ventas::with('producto')->find($cuota->cuotable_id);
        if($cuota->nro_cuota == 1){
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $cuota->fecha_vencimiento)->subMonths(2)->toDateString();
            $cuota->fecha_inicio = $fechaInicio;
        } else {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $cuota->fecha_vencimiento)->subMonth()->toDateString();
            $cuota->fecha_inicio = $fechaInicio;
        }
        if($cuota->estado == 'Cobro Total'){
            $ganancia = round($cuota->importe * $venta->producto->ganancia / 100, 2);
            \App\Movimientos::create(['identificadores_id' => $cuota->id, 'identificadores_type' => 'App\Cuotas', 'entrada' => $cuota->importe, 'salida' => $cuota->importe, 'fecha' => \Carbon\Carbon::today()->toDateString(), 'contabilizado_salida' => 1, 'ganancia' => $ganancia]);
        }
        $cuota->save();
        });
    });
});

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
Route::get('roles/all', 'ABM_roles@all');
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
Route::get('modificarServicioVista', 'VentasControlador@modificarVista');
Route::post('ventas/mostrarPorOrganismo', 'VentasControlador@mostrarPorOrganismo');
Route::post('ventas/datosAutocomplete', 'VentasControlador@traerDatosAutocomplete');
Route::post('ventas/saldo', 'VentasControlador@saldo');
Route::post('ventas/mostrarPorCuotas', 'VentasControlador@mostrarPorCuotas');
Route::post('ventas/mostrarPorVenta', 'VentasControlador@mostrarPorVenta');
Route::post('ventas/mostrarPorSocio', 'VentasControlador@mostrarPorSocio');
Route::post('ventas/cancelarVenta', 'VentasControlador@cancelarVenta');
Route::post('ventas/movimientos', 'VentasControlador@mostrarMovimientosVenta');
Route::post('ventas/modificar', 'VentasControlador@modificar');
Route::get('ventas/all', 'VentasControlador@all');
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
Route::post('comercializador/rechazarPropuesta', 'ComercializadorController@rechazarPropuesta');




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
Route::post('imputacion/autocomplete', 'ABM_Imputacion@autocomplete');
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

Route::get('asientos/{nroAsiento}', 'AsientosController@findFromNumero');
Route::post('asientos/renumerar', 'AsientosController@renumerar');
Route::post('asientos/borrar', 'AsientosController@delete');
Route::post('asientos/editar', 'AsientosController@update');
Route::post('asientos', 'AsientosController@store');
Route::get('asientos', 'AsientosController@index');
Route::get('BMAsientos', 'AsientosController@bajaModificacionVista');

//-------------------- BANCOS ----------------------------------

Route::get('bancos/traerElementos', 'BancoController@all');
Route::resource('bancos', 'BancoController');

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
Route::post('operaciones/autocomplete', 'ABM_Operaciones@autocomplete');
Route::resource('operaciones', 'ABM_Operaciones');


//------------------- Caja Operaciones --------------------------

Route::resource('cajaOperaciones', 'CajaOperacionesController');

//------------------ CHEQUERA --------------------------------

Route::post('chequera/traerElementos', 'ChequeraController@all');
Route::resource('chequera', 'ChequeraController');

//---------------- NOVEDADES ---------------------------------

Route::post('novedades/organismos', 'NovedadesController@mostrarPorOrganismo');
Route::post('novedades/socios', 'NovedadesController@mostrarPorSocio');
Route::resource('novedades', 'NovedadesController');

//----------------- SOLICITUDES PENDIENTES DE COBRO ---------------------

Route::get('solicitudesPendientesDeCobro', 'SolicitudesPendientesDeCobro@index');
Route::get('solicitudesPendientesDeCobro/solicitudes', 'SolicitudesPendientesDeCobro@solicitudes');

//----------------- PAGO SOLICITUDES PENDIENTES DE COBRO ---------------------

Route::get('pagoSolicitudesPendientesDeCobro', 'PagoSolicitudesPendientesDeCobro@index');
Route::get('pagoSolicitudesPendientesDeCobro/comercializadores', 'PagoSolicitudesPendientesDeCobro@comercializadores');
Route::get('pagoSolicitudesPendientesDeCobro/solicitudesComer/{id}', 'PagoSolicitudesPendientesDeCobro@solicitudesTerminadasComer');
Route::post('pagoSolicitudesPendientesDeCobro/pagar', 'PagoSolicitudesPendientesDeCobro@pagar');

//----------------- CUENTA CORRIENTE COMERCIALIZADOR ---------------------

Route::get('cuentaCorrienteComercializador', 'CuentaCorrienteComercializador@index');
Route::get('cuentaCorrienteComercializador/comercializadores', 'CuentaCorrienteComercializador@comercializadores');
Route::get('cuentaCorrienteComercializador/ventasComer/{id}', 'CuentaCorrienteComercializador@solicitudesTerminadasComer');