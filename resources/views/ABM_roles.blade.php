  @extends('welcome')

@section('contenido')

{!! Html::script('js/controladores/ABMroles.js') !!}
  <!-- CSS TABLAS -->
 {!! Html::style('js/datatables/jquery.dataTables.min.css') !!}
  {!! Html::style('js/datatables/buttons.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/fixedHeader.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/responsive.bootstrap.min.css') !!}
  {!! Html::style('js/datatables/scroller.bootstrap.min.css') !!}
<div class="nav-md" ng-controller="ABM" >

  <div class="container body" >
  
    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" name="tipo_tabla" value="roles">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >
         
          <div class="clearfix"></div>

          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Formulario de roles <small>Dar de alta un rol</small></h2>
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
                    
                    <span class="section">Datos de roles</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="name" ng-model="name" placeholder="Ingrese nombre del Rol" type="text">{[{errores.name[0]}]}
                      </div>
                    </div>
                    <input type="hidden" name="slug" value="{[{name}]}">
                    
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numeroDePantallas">Cantidad de pantallas <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="numeroDePantallas" class="form-control col-md-7 col-xs-12" name="numeroDePantallas" ng-model="numeroDePantallas" placeholder="Ingrese cantidad de pantallas" type="text">
                      </div><button type="button" ng-click="agregarPantalla()" class="btn btn-primary">Añadir pantalla</button>
                    </div>
                    
                    <div id="agregarCodigo">                     
                    </div>

                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>

                </div>
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
                    
                    <span class="section">Personal Info</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="usuario" class="form-control col-md-7 col-xs-12" name="usuario" placeholder="Ingrese usuario del organismo" type="text">{[{errores.usuario[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Ingrese email del organismo" type="text">{[{errores.email[0]}]}
                      </div>
                    </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Contraseña <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="password" name="password" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el password">{[{errores.password[0]}]}
                      </div>
                    </div>
                    
                   
                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button id="send" type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
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


            $("#datatable-responsive").DataTable({
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
          });
        </script>
</div>


@endsection