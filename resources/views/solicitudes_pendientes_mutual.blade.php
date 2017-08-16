@extends('welcome')

@section('contenido')


{!! Html::script('js/controladores/solicitudesPendientesMutual.js') !!}

  <!-- CSS TABLAS -->
  <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<div class="nav-md" ng-controller="solicitudesPendientesMutual" >

  <div class="container body" >
  
    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" value="organismos">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >
         
          <div class="clearfix"></div>
          
        </div>



      </div>
      
      

      <div class="col-md-12 col-sm-12 col-xs-12">
      <div id="mensaje"></div>
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Solicitudes Pendientes Mutual</h2>

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
                                                <td title="'Acciones Disponibles'"  style="color: #21a9d6;">
                                                
                                                      <span ng-click="IDModal(solicitud.id)" data-toggle="modal" data-target="#AgenteFinanciero" ng-show="solicitud.agente_financiero == null" class="fa fa-user fa-2x" titulo="Asignar Agente Financiero"></span>

                                                      <span ng-click="IDModal(solicitud.id)" data-toggle="modal" data-target="#Endeudamiento" ng-show="solicitud.doc_endeudamiento == null" class="fa fa-file-text fa-2x" titulo="Numero Endeudamiento"></span>

                                                      
                                                      
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

 
<div id="AgenteFinanciero" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <div class="modal-content">
      <div class="modal-header">
      <div id="mensajemodal"></div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">ASIGNAR AGENTE FINANCIERO</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal form-label-left">
                    <div class="item form-group"> 
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Agente Financiero 
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12"> 
                          <select class="form-control col-sm-3 col-md-7 col-xs-12" ng-model="agente">
                            <option value="{[{x.id}]}" ng-repeat="x in agentes">
                            {[{x.nombre}]}
                            </option>
                          </select>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                      <button type="button" ng-click="AsignarAF()" class="btn btn-primary">ASIGNAR AGENTE FINANCIERO</button>
                      </div>
                    </div>
          </form>
      </div>      
    </div>
  </div>
</div>

<div id="Endeudamiento" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <div class="modal-content">
      <div class="modal-header">
      <div id="mensajemodal2"></div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">ASIGNAR ENDEUDAMIENTO</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal form-label-left">
                    <div class="item form-group"> 
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">ENDEUDAMIENTO 
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12"> 
                          <input id="endeudamiento" class="form-control col-md-7 col-xs-12" name="endeudamiento" placeholder="Ingrese el Endeudamiento" ng-model="endeudamiento" type="number">
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                      <button type="button" ng-click="AsignarEndeudamiento()" class="btn btn-primary">ASIGNAR ENDEUDAMIENTO</button>
                      </div>
                    </div>
          </form>
      </div>      
    </div>
  </div>
</div>

  <!-- bootstrap progress js -->


  <!-- icheck -->
  
  <!-- pace -->
 

  <!-- form validation -->
 
        <script src="js/datatables/jquery.dataTables.min.js"></script>
        <script src="js/datatables/dataTables.bootstrap.js"></script>
        <script src="js/datatables/dataTables.buttons.min.js"></script>
        <script src="js/datatables/buttons.bootstrap.min.js"></script>
        <script src="js/datatables/jszip.min.js"></script>
        <script src="js/datatables/pdfmake.min.js"></script>
        <script src="js/datatables/vfs_fonts.js"></script>
        <script src="js/datatables/buttons.html5.min.js"></script>
        <script src="js/datatables/buttons.print.min.js"></script>
        <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="js/datatables/dataTables.keyTable.min.js"></script>
        <script src="js/datatables/dataTables.responsive.min.js"></script>
        <script src="js/datatables/responsive.bootstrap.min.js"></script>
        <script src="js/datatables/dataTables.scroller.min.js"></script>


<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>

<script type="text/javascript">
    
</script>



         <script>
          
        </script>

</div>


@endsection