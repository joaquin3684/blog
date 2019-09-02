angular.module('verificarBaja', [])
.directive("verificarBaja", function () {
    return {
        template: 
        '<div id="verificarBaja">'+
                '<button data-toggle="modal" data-target="#verificarBaja" class="btn btn-danger" ><span class="glyphicon glyphicon-remove"></span></button>'+
        '<div id="verificarBaja" class="modal fade" role="dialog">'+
            '<div class="modal-dialog" >'+
           ' <div class="modal-content">'+
                '<div class="modal-header">'+
                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                    '<h4 class="modal-title">Advertencia!</h4>'+
                '</div>'+
                '<div class="modal-body" style="display: inline-flex;">'+
                    '<h5 >¿Desea eliminar a &nbsp</h5><h5 style="color: red">{{ elemABorrar.nombre }}{{ elemABorrar.razon_social }}{{ elemABorrar.usuario }}</h5><h5>&nbsp de la lista de elementos?</h5>'+
               ' </div>'+
                '<div class="modal-footer">'+
                    '<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="delete(elemABorrar.id)">Aceptar</button>'+
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
               ' </div>'+
            '</div>'+
            '</div>'+
            '</div>'+
        '</div>'
        
            
        }
 
})
.controller('verificarBaja', function ($scope, $rootScope) {

        $scope.darDeBaja = function(){
            console.log($scope)
            console.log($rootScope)
            console.log($scope.$parent)
         
            //$scope.$parent.enviarFormulario('Borrar', 2)
        }
})
