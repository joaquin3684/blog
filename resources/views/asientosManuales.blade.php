@extends('welcome')

@section('contenido')


{!! Html::script('js/controladores/asientosManuales.js') !!}


<div class="nav-md" ng-controller="asientosManuales" >

  <div class="container body">

    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" value="organismos">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Formulario de asientos manuales </h2>
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
                  @verbatim
                  <form class="form-horizontal form-label-left" id="formulario" ng-submit="verificarIgualdad()">
                   {{ csrf_field() }}

                   <table class="table">
 <thead>
   <tr>

     <th style="text-align: center">Id. imputacion</th>
     <th style="text-align: center">Debe</th>
     <th style="text-align: center">Haber</th>
     <th></th>
   </tr>
 </thead>
 <tbody>

     <tr ng-repeat="asiento in asientos" ng-attr-id="asiento{{$index}}">
       <td style="border-top: 1px solid white;">
           <select class="form-control" id="sel1" ng-model="asiento.id_imputacion">
             <option value="{{id.id}}" ng-repeat="id in idDisponibles">{{id.nombre}}</option>
           </select>
       </td>
       <td style="border-top: 1px solid white;">
         <input type="number" name="" value="" class="form-control" ng-model="asiento.debe" placeholder="Ingrese el valor" ng-disabled="asiento.haber != null" >
       </td>
       <td style="border-top: 1px solid white;">
         <input type="number" name="" value="" class="form-control" ng-model="asiento.haber" placeholder="Ingrese el haber" ng-disabled="asiento.debe != null">
       </td>
       <td style="border-top: 1px solid white;">
         <button id="sumahtml" type="button" class="btn btn-danger"  ng-click="eliminarHtml('#asiento'+$index, asientos,$index)">
         <span class="glyphicon glyphicon-minus" aria-hidden="true" ></span>
       </button>
     <button id="sumahtml" type="button" class="btn btn-primary"  ng-click="agregarHtml(asientos)">
       <span class="glyphicon glyphicon-plus" aria-hidden="true" ></span>
     </button>
      </td>
     </tr>

 </tbody>
    <tfoot>
      <tr style="font-size: initial">
        <th>Totales:</th>
        {{sumarTotales()}}
        <th>{{sumaDebe}}</th>
        <th>{{sumaHaber}}</th>
        <th></th>
      </tr>
    </tfoot>
</table>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancelar</button>
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>
                  @endverbatim

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



</div>


@endsection
