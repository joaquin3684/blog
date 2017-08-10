@extends('welcome')

@section('contenido')

{!! Html::script('js/angular-ui-sortable/src/sortable.js') !!}
{!! Html::script('js/controladores/prioridades.js') !!}

  <!-- CSS TABLAS -->
  {!! Html::style('js/datatables/jquery.dataTables.min.css') !!}
  {!! Html::style('js/datatables/buttons.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/fixedHeader.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/responsive.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/scroller.bootstrap.min.css') !!}

<div class="nav-md" ng-controller="prioridades" >

  <div class="container body" >


    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" name="tipo_tabla" value="prioridades">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >
         
          <div class="clearfix"></div>

          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Formulario de proovedores <small>Dar de alta un proovedor</small></h2>
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
                    
                    <span class="section">Datos de proovedor</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre de la prioridad" type="text">{[{errores.nombre[0]}]}
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

         <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Prioridades <small></small></h2>
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
                        
                        <table id="datatable-responsive" cellspacing="0" class="table table-striped " cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nombre</th>
                              <th></th>
                                                           
                            </tr>
                          </thead>
                          
                          <tbody ui-sortable="sortableOptions" ng-model="datos">
                            <tr ng-repeat="x in datos">
                              <td>{[{x.nombre}]}</td>
                              <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', x.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                              <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', x.id)"><span class="glyphicon glyphicon-remove"></span></button>
                                </td>
                            </tr>
    
                          </tbody>
                        </table>
                        <button class="btn btn-success" ng-click="guardarConfiguracion()">Guardar</button>
                      </div>
                    </div>
                  </div>

       

      </div>


       <!-- /page content -->
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
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del organismo" type="text">{[{errores.nombre[0]}]}
                      </div>
                    </div>
                    
                   
                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button id="send" type="submit" class="btn btn-success">Enviar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </form>
      </div>
      
    </div>

  </div>
</div>
<!-- Fin Modal -->
    </div>






        
</div>


@endsection