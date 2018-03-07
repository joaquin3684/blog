angular.module('ejercicio', [])
    .directive("ejercicio", function () {
        return {
            template:
                ''+
                '<div class="modal fade" id="ejercicio" role="dialog" data-backdrop="false">'+
                    '<div class="modal-dialog" role="document">'+
                        '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                '<h4 class="modal-title">Ejercicio</h4>'+
                            '</div>'+
                            '<div class="modal-body">'+
                                '<form class="form-horizontal form-label-left">'+
                                    '<div class="item form-group">'+
                                        '<label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha</label>'+
                                        '<div class="col-md-6 col-sm-6 col-xs-12">'+
                                            '<input class="form-control col-md-7 col-xs-12" type="date" ng-model="fecha">'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="ln_solid"></div>'+
                                       ' <div class="form-group">'+
                                          '  <div class="col-md-6 col-md-offset-3">'+
                                                '<button type="button" class="btn btn-primary" ng-click="abrirEjercicio()">Abrir</button>'+
                                                '<button type="button" class="btn btn-success" ng-click="cerrarEjercicio()">Cerrar</button>'+
                                            '</div>'+
                                        '</div>'+
                                '</form>'+
                            ' </div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
        }

    });