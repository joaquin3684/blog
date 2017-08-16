
<!DOCTYPE html>
<html lang="en" ng-app="Mutual">
<body>
{!! Html::style('js/angular-material/angular-material.min.css') !!}
{!! Html::style('css/bootstrap.min.css') !!}
{!! Html::style('fonts/css/font-awesome.min.css') !!}

{!! Html::style('css/animate.min.css') !!}
{!! Html::script('js/moment/moment.min.js') !!}
<!-- Custom styling plus plugins -->

{!! Html::style('css/custom.css') !!}
{!! Html::style('css/icheck/flat/green.css') !!}
{!! Html::style('css/barrow.css') !!}
{!! Html::style('css/floatexamples.css') !!}
{!! Html::style('css/ng-table.min.css') !!}

{!! Html::script('js/jquery.min.js') !!}
{!! Html::script('js/jquery-ui-1.12.1/jquery-ui.min.js') !!}
{!! Html::style('js/jquery-ui-1.12.1/jquery-ui.min.css') !!}
{!! Html::script('js/angular.min.js') !!}
{!! Html::script('js/nprogress.js') !!}
{!! Html::script('js/misFunciones.js') !!}
{!! Html::script('js/angular-animate/angular-animate.min.js') !!}
{!! Html::script('js/ng-table.min.js') !!}

{!! Html::script('js/angular-aria/angular-aria.min.js') !!}
{!! Html::script('js/angular-messages/angular-messages.min.js') !!}
{!! Html::script('js/angular-material/angular-material.min.js') !!}

{!! Html::script('js/angular-sanitize/angular-sanitize.min.js') !!}
{!! Html::script('js/services.js') !!}


<div id="responseImage" ng-controller="prueba">
<button ng-click="enviarImagenes()">fsdfdsd</button>
</div>
<script>
    var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize'])
    app.controller('prueba', function($scope, $http, $compile, $sce) {
        $scope.enviarImagenes = function(){
            $http({
                url: 'pruebas',
                method: 'post',
                data: {'imagenes': {'1': '1', '2':'2'}},
            }).then(function successCallback(response)
            {
                console.log(response)
            }, function errorCallback(data)
            {
                console.log(data);
            });
        }
    });
    </script>
</body>
</html>