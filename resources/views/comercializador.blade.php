@extends('welcome')

@section('contenido')


{!! Html::script('js/ng-file-upload.min.js') !!}
{!! Html::script('js/controladores/comercializador.js') !!}


  <!-- CSS TABLAS -->
  <script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
  </script>
  <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<div class="nav-md" ng-controller="comercializador" >

  <div class="container body" >
  
    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" value="organismos">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >
         
          <div class="clearfix"></div>
          
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
            <div id="mensaje"></div>
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Generar Solicitud<small>Dar de alta un prestamo a un comercializador</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <form class="form-horizontal form-label-left" id="formulario" >
                   {{ csrf_field() }}
                    
                    <span class="section">Generar Solicitud</span>
                    
                    <div class="item form-group"> 
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Organismo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12"> 
                          <select class="form-control col-sm-3 col-md-7 col-xs-12" ng-model="organismocomplete">
                            <option value="{[{x.id}]}" ng-repeat="x in organismos">
                            {[{x.nombre}]}
                            </option>
                          </select>
                      </div>
                    </div>
                    

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <md-autocomplete class="" md-input-name="idafiliado" md-item-text="item.nombre" md-items="item in query(searchText, 'filtroSocios')" md-search-text="searchText" md-selected-item="socio" placeholder="Buscar afiliado...">
                                                <span md-highlight-text="searchText">
                                                    {[{item.nombre}]}
                                                </span>
                        </md-autocomplete>
                      </div>
                    </div>
                    <div ng-show="socio == null || socio == ''">
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del organismo" ng-model="nombre" type="text">{[{errores.nombre[0]}]}
                      </div>
                    </div>
                    
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Apellido <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" name="apellido" ng-model="apellido" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Apellido">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuota_social">DNI <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="dni" name="dni" ng-model="dni" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el DNI">{[{errores.dni[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuota_social">Cuit <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="cuota_social" name="cuit" ng-model="cuit" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Cuit">{[{errores.cuota_social[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuota_social">Fecha Nacimiento <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" ng-model="fecha_nacimiento" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Cuit">{[{errores.cuota_social[0]}]}
                      </div>
                    </div>
                        
                    <div flex layout="row" class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuota_social">Sexo <span class="required">*</span>
                      </label>
                      <div  class="col-md-6 col-sm-6 col-xs-12">
                        
                        <md-radio-group flex layout="row" ng-model="sexo">

                          <md-radio-button flex value="Masculino" class="md-primary">Masculino</md-radio-button>
                          <md-radio-button flex value="Femenino">Femenino</md-radio-button>
                        </md-radio-group>

                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuota_social">Legajo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="legajo" name="legajo" ng-model="legajo" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Legajo">{[{errores.legajo[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Domicilio <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" name="domicilio" ng-model="domicilio" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Domicilio">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuota_social">Localidad <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="localidad" name="localidad" ng-model="localidad" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la Localidad">{[{errores.localidad[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Telefono <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" name="telefono" ng-model="telefono" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Telefono">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Codigo Postal <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" name="codigo_postal" ng-model="codigo_postal" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Codigo Postal">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                  </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Copia del Documento <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input ngf-select name="file" ngf-pattern="'image/*'"
    ngf-accept="'image/*'" type="file" id="cuit" name="cuit" ng-model="doc_documento" class="form-control col-md-7 col-xs-12" placeholder="">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Copia del Recibo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input ngf-select name="file" ngf-pattern="'image/*'"
    ngf-accept="'image/*'" type="file" id="cuit" name="cuit" ng-model="doc_recibo" class="form-control col-md-7 col-xs-12" placeholder="">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"  for="cuit">Copia del Domicilio <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input ngf-select name="file" ngf-pattern="'image/*'"
    ngf-accept="'image/*'" ng-model="doc_domicilio" type="file" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" placeholder="">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" ng-model="doc_cbu" for="cuit">Copia del CBU <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input ngf-select name="file" ngf-pattern="'image/*'"
    ngf-accept="'image/*'" type="file" ng-model="doc_cbu" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" placeholder="">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" ng-model="doc_endeudamiento" for="cuit">Certificado de Endeudamiento
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input ngf-select name="file" ngf-pattern="'image/*'"
    ngf-accept="'image/*'" type="file" ng-model="doc_endeudamiento" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" placeholder="">{[{errores.cuit[0]}]}
                      </div>
                    </div>
        
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" onclick="console.log('hola');" class="btn btn-primary">Cancel</button>
                        <button id="send" type="submit" ng-click="AltaComercializador()" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>



      </div>
      
      

      <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Solicitudes <small>Todas las solicitudes realizadas</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a href="#"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>

                      <div class="x_content">
                     <center>
                     <button id="exportButton1" ng-click="ExportarPDF('organismos')" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
                     </button>
                     <button id="exportButton2" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     <button id="exportButton3" ng-click="Impresion()" class="btn btn-primary clearfix"><span class="fa fa-print"></span> IMPRIMIR</button>
                     </center>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div id="exportTable">
                                        <table id="tablita" ng-table="paramssolicitudes" class="table table-hover table-bordered">
                                        
                                            <tbody data-ng-repeat="solicitud in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos">
                                                <td title="'Nombre'" sortable="'nombre'">
                                                    {[{solicitud.socio.nombre}]}
                                                </td>
                                                <td title="'Apellido'" sortable="'apellido'">
                                                    {[{solicitud.socio.apellido}]}
                                                </td>
                                                <td title="'Cuit'" sortable="'cuit'">
                                                    {[{solicitud.socio.cuit}]}
                                                </td>
                                                <td title="'Sexo'" sortable="'sexo'">
                                                    {[{solicitud.socio.sexo}]}
                                                </td>
                                                <td title="'Domicilio'" sortable="'domicilio'">
                                                    {[{solicitud.socio.domicilio}]}
                                                </td>
                                                <td title="'Telefono'" sortable="'telefono'">
                                                    {[{solicitud.socio.telefono}]}
                                                </td>
                                                <td title="'Codigo Postal'" sortable="'codigo_postal'">
                                                    {[{solicitud.socio.codigo_postal}]}
                                                </td>
                                                <td title="'Estado'" sortable="'estado'">
                                                    {[{solicitud.estado}]}
                                                </td>
                                                <td title="'Acciones Disponibles'" style="color: #21a9d6;">
                                                    
                                                    <span data-toggle="modal" data-target="#Comprobantes" ng-click="getFotos(solicitud.id)" class="fa fa-file-picture-o fa-2x" titulo="Ver Comprobantes"></span>

                                                    <span ng-show="solicitud.estado == 'Esperando Respuesta Comercializador'" ng-click="IDPropuesta(solicitud.id,solicitud.total,solicitud.monto_por_cuota,solicitud.cuotas)" data-toggle="modal" data-target="#ContraPropuesta" class="fa fa-eye fa-2x" titulo="Analizar Propuesta"></span>

                                                    <span ng-show="solicitud.estado == 'Capital Reservado'" class="fa fa-print fa-2x" ng-click="ImprimirFormulario()" titulo="Imprimir Formulario"></span>

                                                    <span ng-show="solicitud.estado == 'Capital Reservado'" class="fa fa-send fa-2x" ng-click="EnviarFormulario(solicitud.id)" titulo="Enviar Formulario"></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- END TABLE -->
                                </div>
                            </div>

                        </div>
                    </div>
                  </div>


      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

 <!-- Modal -->
<div id="ContraPropuesta" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <div id="mensajemodal"></div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Analizar Propuesta</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar" >
                   
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Importe 
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12" style="vertical-align: text-middle; color: blue;">
                        <input id="importe" ng-disabled="!modificandopropuesta" class="form-control col-md-7 col-xs-12" name="importe" placeholder="Ingrese el importe" type="number" ng-model="importe" step="0.01">{[{errores.importe[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Cuotas">Cuotas
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" ng-disabled="!modificandopropuesta" class="form-control col-md-7 col-xs-12" name="Cuotas" placeholder="Ingrese el nro de cuotas" type="number" ng-model="cuotas" step="0.01">{[{errores.nombre[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="MontoPorCuota">Monto por Cuota
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input ng-disabled="!modificandopropuesta" id="nombre" class="form-control col-md-7 col-xs-12" name="MontoPorCuota" placeholder="Ingrese el nro de cuotas" ng-model="monto_por_cuota" type="number" step="0.01">{[{errores.nombre[0]}]}
                      </div>
                    </div>
                    
                   
                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-12">
                      <center>
                      <button data-dismiss="modal" type="button" ng-show="!modificandopropuesta" ng-click="AceptarPropuesta()" class="btn btn-primary">ACEPTAR PROPUESTA</button>
                        <button id="send" ng-show="!modificandopropuesta" ng-click="ModificarPropuesta(true)" class="btn btn-warning">MODIFICAR</button>

                        <button data-dismiss="modal" id="send" ng-show="modificandopropuesta" ng-click="PropuestaModificada()" class="btn btn-success">ENVIAR CONTRAPROPUESTA</button>
                        <button id="send" ng-show="modificandopropuesta" ng-click="ModificarPropuesta(false)" class="btn btn-danger">CANCELAR</button>
                        </center>
                      </div>
                    </div>
                  </form>
      </div>
      
    </div>

  </div>


</div>

<div id="Comprobantes" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Visualización de Comprobantes</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar" >
                    <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="comprob">Comprobante: 
                        </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        
                        <select ng-change="Comprobante()" class="form-control" placeholder="Comprobante a visualizar.." ng-model="comprobantevisualizar" >
                          <option ng-repeat="x in DatosModalActual" ng-value="x.encoded" >
                            {[{x.filename}]}
                          </option>
                        </select>
                      </div>
                    </div>

                   

                    </br>
                    <center>Previsualización</center>
                    </br>
                    <center><img src="images/preload.png" height="300px" width="300px" id="previsualizacion"></center>
         </form>
      </div>
      
    </div>

  </div>


</div>

</div>


@endsection