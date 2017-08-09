@extends('welcome')

@section('contenido')

    {!! Html::script('js/controladores/ABMprueba.js') !!}
    <!-- CSS TABLAS -->
    {!! Html::style('js/datatables/jquery.dataTables.min.css') !!}
    {!! Html::style('js/datatables/buttons.bootstrap.min.css') !!}
    {!! Html::style('js/datatables/fixedHeader.bootstrap.min.css') !!}
    {!! Html::style('js/datatables/responsive.bootstrap.min.css') !!}
    {!! Html::style('js/datatables/scroller.bootstrap.min.css') !!}
    <div class="nav-md" ng-controller="ABM" >

        <div class="container body" >


            <div class="main_container" >

                <input type="hidden" id="tipo_tabla" name="tipo_tabla" value="productos" ng-init="traerRelaciones([{tabla:'proovedores',select:'#proovedor'}])">
                <!-- page content -->
                <div class="left-col" role="main" >

                    <div class="" >

                        <div class="clearfix"></div>
                        <div id="mensaje"></div>
                        <div class="row" >
                            <div class="col-md-12 col-sm-12 col-xs-12" >
                                <div class="x_panel"  >
                                    <div class="x_title">
                                        <h2>Formulario de Productos <small>Dar de alta un Producto</small></h2>
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

                                        <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Alta')" id="formulario" >
                                            {{ csrf_field() }}

                                            <span class="section">Datos del Producto</span>

                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del producto" type="text">{[{errores.nombre[0]}]}
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Descripcion <span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="descripcion" class="form-control col-md-7 col-xs-12" name="descripcion" placeholder="Ingrese la descripcion" type="text">{[{errores.nombre[0]}]}
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_retencion">Porcentaje de Ganancia <span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="number" step="0.01" id="retencion" name="retencion" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el %">{[{errores.porcentaje_retencion[0]}]}
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Proovedor <span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select id="proovedor" name="id_proovedor" class="form-control col-md-7 col-xs-12" ></select>
                                                </div>

                                            </div>
                                            <div class="ln_solid"></div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <button type="submit" class="btn btn-primary">Cancel</button>
                                                    <button id="send" type="submit" name="enviar" class="btn btn-success">Alta</button>
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
                            <h2>Productos <small>Todos los productos disponibles</small></h2>
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
<!--                         <div class="x_content">

                            <table id="datatable-responsive" cellspacing="0" class="table table-striped table-bordered dt-responsive nowrap order-colum compact" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>% de Ganancia</th>
                                    <th>Proovedor</th>
                                    <th></th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($registros as $registro)
                                    <tr>
                                        <td>{{ $registro->nombre }}</td>
                                        <td>{{ $registro->descripcion }}</td>
                                        <td>{{ $registro->retencion }}</td>
                                        <td>{{ $registro->proovedor['nombre'] }}</td>
                                        <td>@if(Sentinel::check()->hasAccess('organismos.editar'))<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', {{$registro->id}})"><span class="glyphicon glyphicon-pencil"></span></button>@endif
                                            @if(Sentinel::check()->hasAccess('organismos.borrar'))  <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', {{$registro->id}})"><span class="glyphicon glyphicon-remove"></span></button>@endif
                                        </td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div> -->
                        
                    <div class="x_content" id="impr">
                    <center>
                     <button id="exportButton1" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
                     </button>
                     <button id="exportButton2" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     </center>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div>
                                        <table ng-table="paramsABMS" class="table table-hover table-bordered">
                                            <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos">
                                                <td title="'Nombre'" sortable="'nombre'">
                                                    {[{abm.nombre}]}
                                                </td>
                                                <td title="'Descripcion'" sortable="'descripcion'">
                                                    {[{abm.descripcion}]}
                                                </td>
                                                <td title="'Retencion'" sortable="'retencion'">
                                                    {[{abm.ganancia}]}
                                                </td>
                                                <td title="'Proveedor'" sortable="'proovedor'">
                                                    {[{abm.proovedor}]}
                                                </td>
                                                <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', abm.id)"><span class="glyphicon glyphicon-remove"></span></button>
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
        <div id="editar" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar" >
                            {{ csrf_field() }}
                            <p>For alternative validation library <code>parsleyJS</code> check out in the <a href="form.html">form page</a>
                            </p>
                            <span class="section">Personal Info</span>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del producto" type="text">{[{errores.nombre[0]}]}
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Descripcion <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="descripcion" class="form-control col-md-7 col-xs-12" name="descripcion" placeholder="Ingrese la descripcion" type="text">{[{errores.nombre[0]}]}
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_retencion">Porcentaje de Ganancia <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="number" id="retencion" name="retencion" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el %">{[{errores.porcentaje_retencion[0]}]}
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Proovedor <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="proovedor_Editar" name="id_proovedor" class="form-control col-md-7 col-xs-12" ></select>
                                </div>

                            </div>
                            <input type="hidden" name="id">
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                    <button id="send" type="submit" class="btn btn-success">Enviar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
        <!-- Fin Modal -->
        <!-- bootstrap progress js -->


        <!-- icheck -->

        <!-- pace -->


        <!-- form validation -->

        {!! Html::script('js/datatables/jquery.dataTables.min.js') !!}
        {!! Html::script('js/datatables/dataTables.bootstrap.js') !!}
        {!! Html::script('js/datatables/dataTables.buttons.min.js') !!}
        {!! Html::script('js/datatables/buttons.bootstrap.min.js') !!}
        {!! Html::script('js/datatables/jszip.min.js') !!}
        {!! Html::script('js/datatables/pdfmake.min.js') !!}
        {!! Html::script('js/datatables/vfs_fonts.js') !!}
        {!! Html::script('js/datatables/buttons.html5.min.js') !!}
        {!! Html::script('js/datatables/buttons.print.min.js') !!}
        {!! Html::script('js/datatables/dataTables.fixedHeader.min.js') !!}
        {!! Html::script('js/datatables/dataTables.keyTable.min.js') !!}
        {!! Html::script('js/datatables/dataTables.responsive.min.js') !!}
        {!! Html::script('js/datatables/responsive.bootstrap.min.js') !!}
        {!! Html::script('js/datatables/dataTables.scroller.min.js') !!}




        <script>

        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                var tabla =  $("#datatable-responsive").DataTable({
                    select: true,
                    fixedHeader: true,
                    language: {
                        info: "Mostrando del _PAGE_ al _END_ de _TOTAL_ registros",
                        lengthMenu: "Mostrar _MENU_ registros",
                        paginate: {
                            next: "Siguiente",
                            previous: "Anterior"
                        },
                        search: "Buscar:"


                    },
                    dom: 'Blfrtip',
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    lengthChange: true,

                });
                function prueba(){
                    console.log('entrra');
                    tabla.draw();
                }
            });
        </script>
    </div>


@endsection