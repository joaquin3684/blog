@extends('welcome') @section('contenido') {!! Html::script('js/controladores/agente_financiero.js') !!}


<div class="nav-md" ng-controller="agente_financiero">
  <!-- <div style="margin-left: -250px; margin-top: -10px; padding: 0px; width: 100%; height: 100%; float: left; background-color: rgba(157, 157, 157, 0.3); z-index: 1000; position: fixed;">
<center>
  <div style="width: 300px; padding: 15px; border-radius: 5px; margin-top: 20%; background-color: rgba(255, 255, 255, 0.7); color: grey; font-size: 30pt;">
    <i style="font-size: 40pt;" class="fa fa-spinner fa-spin"></i></br>
    CARGANDO
  </div>
</center>
</div> -->

  <div class="container body">

    <div class="main_container">

      <input type="hidden" id="tipo_tabla" value="organismos">
      <!-- page content -->
      <div class="left-col" role="main">

        <div class="">

          <div class="clearfix"></div>

        </div>



      </div>


      @if(Sentinel::check()->hasAccess('agentesFinancieros.visualizar'))
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="mensaje"></div>
        <div class="x_panel">
          <div class="x_title">
            <h2>Solicitudes Disponibles (AF) </h2>

            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li>
                    <a href="#">Settings 1</a>
                  </li>
                  <li>
                    <a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-close"></i>
                </a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">
            <center>
              <button id="exportButton1" ng-click="ExportarPDF('organismos')" class="btn btn-danger clearfix">
                <span class="fa fa-file-pdf-o"></span> PDF
              </button>
              <button id="exportButton2" class="btn btn-success clearfix">
                <span class="fa fa-file-excel-o"></span> EXCEL</button>
              <button id="exportButton3" ng-click="Impresion()" class="btn btn-primary clearfix">
                <span class="fa fa-print"></span> IMPRIMIR</button>

            </center>
            <div id="pruebaExpandir">
              <div class="span12 row-fluid">

                <div id="exportTable">
                  <table id="tablita" ng-table="paramssolicitudes" class="table table-hover table-bordered">

                    <tbody data-ng-repeat="solicitud in $data" data-ng-switch on="dayDataCollapse[$index]">
                      <tr class="clickableRow" title="Datos" ng-cloak>
                        <td title="'Nombre'" sortable="'nombre'">
                          {[{solicitud.socio.nombre}]}
                        </td>
                        <td title="'Apellido'" sortable="'apellido'">
                          {[{solicitud.socio.apellido}]}
                        </td>
                        <td title="'Cuit'" sortable="'cuit'">
                          {[{solicitud.socio.cuit}]}
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
                        
                          <span data-toggle="modal" data-target="#Comprobantes" ng-click="getFotos(solicitud.id)" class="fa fa-file-picture-o fa-2x"
                            titulo="Ver Comprobantes"></span>
                       
                        @if(Sentinel::check()->hasAccess('agentesFinancieros.crear'))
                          <span ng-show="solicitud.estado == 'Agente Financiero Asignado' || solicitud.estado == 'Modificada por Comercializador'"
                            ng-click="RechazarSolicitud(solicitud.id)" class="fa fa-close fa-2x" titulo="Rechazar Solicitud"></span>

                          <span ng-click="IDModal(solicitud)" ng-show="solicitud.estado == 'Agente Financiero Asignado'" data-toggle="modal" data-target="#Propuesta"
                            class="fa fa-send fa-2x" titulo="Enviar Propuesta"></span>

                          <span ng-click="ReservarCapital(solicitud.id)" ng-show="solicitud.estado == 'Aceptada por Comercializador'" class="fa fa-dollar fa-2x"
                            titulo="Reservar Capital"></span>

                          <span ng-click="OtorgarCapital(solicitud.id)" ng-show="solicitud.estado == 'Formulario Enviado'" class="fa fa-money fa-2x"
                            titulo="Otorgar Capital"></span>

                          <span ng-show="solicitud.estado == 'Modificada por Comercializador'" ng-click="IDPropuesta(solicitud.id,solicitud.total,solicitud.monto_por_cuota,solicitud.cuotas)"
                            data-toggle="modal" data-target="#AnalizarPropuesta" class="fa fa-eye fa-2x" titulo="Analizar Propuesta"></span>
                        @endif

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
      @endif


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

  <div id="AnalizarPropuesta" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <div id="mensajemodal2"></div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Analizar Contra Propuesta</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar">

            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Importe
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12" style="vertical-align: text-middle; color: blue;">
                <input id="importe" ng-disabled="!modificandopropuesta" class="form-control col-md-7 col-xs-12" name="importe" placeholder="Ingrese el importe"
                  type="number" ng-model="importe" step="0.01">{[{errores.importe[0]}]}
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Cuotas">Cuotas
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" ng-disabled="!modificandopropuesta" class="form-control col-md-7 col-xs-12" name="Cuotas" placeholder="Ingrese el nro de cuotas"
                  type="number" ng-model="cuotas" step="0.01">{[{errores.nombre[0]}]}
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="MontoPorCuota">Monto por Cuota
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input ng-disabled="!modificandopropuesta" id="nombre" class="form-control col-md-7 col-xs-12" name="MontoPorCuota" 
                  ng-model="monto_por_cuota" type="number" step="0.01">{[{errores.nombre[0]}]}
              </div>
            </div>


            <input type="hidden" name="id">
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-12">
                <center>
                  <button type="button" ng-show="!modificandopropuesta" ng-click="AceptarContraPropuesta()" class="btn btn-primary">ACEPTAR CONTRAPROPUESTA</button>

                  <button id="send" ng-show="!modificandopropuesta" ng-click="RechazarContraPropuesta()" class="btn btn-danger">RECHAZAR</button>

                  <button id="send" ng-show="!modificandopropuesta" ng-click="ModificarPropuesta(true)" class="btn btn-warning">MODIFICAR</button>

                  <button id="send" ng-show="modificandopropuesta" ng-click="PropuestaModificada()" class="btn btn-success">ENVIAR CONTRAPROPUESTA</button>

                  <button id="send" ng-show="modificandopropuesta" ng-click="ModificarPropuesta(false)" class="btn btn-danger">CANCELAR</button>


                </center>
              </div>
            </div>
          </form>
        </div>

      </div>

    </div>


  </div>

  <div id="Propuesta" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <div id="mensajemodal"></div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ENVIAR PROPUESTA AL COMERCIALIZADOR</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar">
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Importe
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input ng-change="calcularMontoPorCuota()" ng-keyup="$event.keyCode == 13 && EnviarPropuesta()" id="nombre" class="form-control col-md-7 col-xs-12"
                  name="Importe" placeholder="Ingrese el importe" type="number" ng-model="importe" step="0.01">{[{errores.nombre[0]}]}
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Cuotas">Cuotas
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input ng-change="calcularMontoPorCuota()" ng-keyup="$event.keyCode == 13 && EnviarPropuesta()" id="nombre" class="form-control col-md-7 col-xs-12"
                  name="Cuotas" placeholder="Ingrese el nro de cuotas" type="number" ng-model="cuotas" step="0.01">{[{errores.nombre[0]}]}
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="MontoPorCuota">Monto por Cuota
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input disabled ng-keyup="$event.keyCode == 13 && EnviarPropuesta()" id="nombre" class="form-control col-md-7 col-xs-12"
                  name="MontoPorCuota"  ng-model="monto_por_cuota" type="number">{[{errores.nombre[0]}]}
              </div>
            </div>


            <input type="hidden" name="id">
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <button ng-keyup="$event.keyCode == 13 && EnviarPropuesta()" type="button" ng-click="EnviarPropuesta()" class="btn btn-primary">ENVIAR PROPUESTA</button>
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
          <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar">
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="comprob">Comprobante:
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">

                <select ng-change="Comprobante()" class="form-control" placeholder="Comprobante a visualizar.." ng-model="comprobantevisualizar">
                  <option ng-if="x.filename != null" ng-repeat="x in DatosModalActual" ng-value="x.encoded">
                    {[{x.filename}]}
                  </option>
                  <option ng-if="x.filename == null" ng-repeat="x in DatosModalActual" ng-value="x">
                    doc_endeudamiento
                  </option>
                </select>
              </div>
            </div>
            <center>
              <div id="endeudamientodiv" style="color: black; display: none; font-size: 20pt;">
                Número de Endeudamiento:
                <b>
                  <a id="endeud" style="color: blue;"></a>
                </b>
              </div>
            </center>
            <div id="previsualizaciondiv">
              </br>
              <center>Previsualización</center>
              </br>
              <center>
                <img src="images/preload.png" id="previsualizacion" class="imgAExpandir" data-toggle="modal" data-target="#modalExpandirImg"
                  ng-click="expandirImg()">
              </center>
            </div>
          </form>
        </div>

      </div>

    </div>


  </div>
  
  <!-- The Modal -->
  <div id="modalExpandirImg" class="modalExpandir fade">
    <!-- The Close Button -->
    <span class="close" data-dismiss="modal">&times;</span>
    <!-- Modal Content (The Image) -->
    <img class="modal-contentExpandirImg" id="imgExpandida">
    <br>
    <a ng-href="{[{imageSrc}]}" download>
      <center style="color: white">
        <h4>Descargar
          <i class="fa fa-download" aria-hidden="true"></i>
        </h4>
      </center>
    </a>
  </div>

</div>


@endsection