var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('ventas', function($scope, $http, $compile, $sce, $window, NgTableParams, $filter) {
    
$scope.ActualDate = moment().format('YYYY-MM-DD');

//mostrarPorSocio en todos mando el id del de atras boludo es asi
    //mostrarPorVenta
    //mostrarPorCuotas
// ESTAS FUNCIONES SON PARA DEFINIR LOS PARAMETROS DE BUSQUEDA EN LA FUNCION QUERY
$scope.pullOrganismos = function (){

$http({
         url: 'ventas/mostrarPorOrganismo',
         method: 'post'
         }).then(function successCallback(response)
            {
               console.log(response.data.ventas);
               if(typeof response.data === 'string')
               {
                  return [];
               }
               else
               {
                  console.log(response);
                  $scope.organismos = response.data;
                  $scope.paramsOrganismos = new NgTableParams({
                       page: 1,
                       count: 10
                   }, {
                       total: $scope.organismos.length,
                       getData: function (params) {
                           $scope.organismos = $filter('orderBy')($scope.organismos, params.orderBy());
                           return $scope.organismos.slice((params.page() - 1) * params.count(), params.page() * params.count());
                       }
                   });
               }

            }, function errorCallback(data)
            {
               console.log(data.data);
            });



}

$scope.PullSocios = function(idorganismo,nombreorganismo){


    $http({
        url: 'ventas/mostrarPorSocio',
        method: 'post',
        data: {'id': idorganismo}
    }).then(function successCallback(response)
    {
        console.log(response.data.ventas);
        if(typeof response.data === 'string')
        {
            return [];
        }
        else
        {
            console.log(response);
            $scope.socios = response.data;
            $scope.vistaactual = 'Socios';
            $scope.organismoactual = nombreorganismo;
            $scope.paramsSocios = new NgTableParams({
                page: 1,
                count: 10
            }, {
                total: $scope.socios.length,
                getData: function (params) {
                    $scope.socios = $filter('orderBy')($scope.socios, params.orderBy());
                    return $scope.socios.slice((params.page() - 1) * params.count(), params.page() * params.count());
                }
            });
        }

    }, function errorCallback(data)
    {
        console.log(data.data);
    });

}
    $scope.setVista = function(vista){

        $scope.vistaactual = vista;

    }

    $scope.PullVentas = function(idsocio,nombresocio){


        $http({
            url: 'ventas/mostrarPorVenta',
            method: 'post',
            data: {'id': idsocio}
        }).then(function successCallback(response)
        {
            console.log(response.data.ventas);
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.ventas = response.data;
                $scope.vistaactual = 'Ventas';
                $scope.socioactual = nombresocio;
                //self.paramsVentas = new NgTableParams({}, { dataset: $scope.ventas});

                $scope.paramsVentas = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.ventas.length,
                    getData: function (params) {
                        $scope.ventas = $filter('orderBy')($scope.ventas, params.orderBy());
                        return $scope.ventas.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });

    }


    $scope.PullCuotas = function(idventa,nombreproducto){


        $http({
            url: 'ventas/mostrarPorCuotas',
            method: 'post',
            data: {'id': idventa}
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {

                $scope.cuotas = response.data.cuotas;
                //var datacuotas = response.data;
                $scope.productodelacuota = response.data.producto.proovedor.nombre;
                $scope.vistaactual = 'Cuotas';
                console.log(response);
                $scope.productoactual = nombreproducto;
                $scope.paramsCuotas = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.cuotas.length,
                    getData: function (params) {
                        $scope.cuotas = $filter('orderBy')($scope.cuotas, params.orderBy());
                        return $scope.cuotas.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });

    }

    //PARAMETROS INICIALES
        $scope.vistaactual = 'Organismos';
        var self = this;
        $scope.pullOrganismos();

    //EMPIEZA EL CODIGO DEL EXPANDIR
    $scope.tableRowExpanded = false;
    $scope.tableRowIndexExpandedCurr = "";
    $scope.tableRowIndexExpandedPrev = "";
    $scope.storeIdExpanded = "";

    $scope.dayDataCollapseFn = function () {
        $scope.dayDataCollapse = [];
        for (var i = 0; i < $scope.storeDataModel.storedata.length; i += 1) {
            $scope.dayDataCollapse.push(false);
        }
    };


    $scope.selectTableRow = function (index, storeId) {
        if (typeof $scope.dayDataCollapse === 'undefined') {
            $scope.dayDataCollapseFn();
        }

        if ($scope.tableRowExpanded === false && $scope.tableRowIndexExpandedCurr === "" && $scope.storeIdExpanded === "") {
            $scope.tableRowIndexExpandedPrev = "";
            $scope.tableRowExpanded = true;
            $scope.tableRowIndexExpandedCurr = index;
            $scope.storeIdExpanded = storeId;
            $scope.dayDataCollapse[index] = true;
        } else if ($scope.tableRowExpanded === true) {
            if ($scope.tableRowIndexExpandedCurr === index && $scope.storeIdExpanded === storeId) {
                $scope.tableRowExpanded = false;
                $scope.tableRowIndexExpandedCurr = "";
                $scope.storeIdExpanded = "";
                $scope.dayDataCollapse[index] = false;
            } else {
                $scope.tableRowIndexExpandedPrev = $scope.tableRowIndexExpandedCurr;
                $scope.tableRowIndexExpandedCurr = index;
                $scope.storeIdExpanded = storeId;
                $scope.dayDataCollapse[$scope.tableRowIndexExpandedPrev] = false;
                $scope.dayDataCollapse[$scope.tableRowIndexExpandedCurr] = true;
            }
        }

    };

    $scope.storeDataModel = {
        "metadata": {
            "storesInTotal": "25",
            "storesInRepresentation": "6"
        },
        "storedata": [{
            "store": {
                "storeId": "1000",
                "storeName": "Store 1",
                "storePhone": "+46 31 1234567",
                "storeAddress": "Avenyn 1",
                "storeCity": "Gothenburg"
            },
            "data": {
                "startDate": "2013-07-01",
                "endDate": "2013-07-02",
                "costTotal": "100000",
                "salesTotal": "150000",
                "revenueTotal": "50000",
                "averageEmployees": "3.5",
                "averageEmployeesHours": "26.5",
                "dayData": [{
                    "date": "2013-07-01",
                    "cost": "50000",
                    "sales": "71000",
                    "revenue": "21000",
                    "employees": "3",
                    "employeesHoursSum": "24"
                }, {
                    "date": "2013-07-02",
                    "cost": "50000",
                    "sales": "79000",
                    "revenue": "29000",
                    "employees": "4",
                    "employeesHoursSum": "29"
                }]
            }
        }, {
            "store": {
                "storeId": "2000",
                "storeName": "Store 2",
                "storePhone": "+46 8 9876543",
                "storeAddress": "Drottninggatan 100",
                "storeCity": "Stockholm"
            },
            "data": {
                "startDate": "2013-07-01",
                "endDate": "2013-07-02",
                "costTotal": "170000",
                "salesTotal": "250000",
                "revenueTotal": "80000",
                "averageEmployees": "4.5",
                "averageEmployeesHours": "35",
                "dayData": [{
                    "date": "2013-07-01",
                    "cost": "85000",
                    "sales": "120000",
                    "revenue": "35000",
                    "employees": "5",
                    "employeesHoursSum": "38"
                }, {
                    "date": "2013-07-02",
                    "cost": "85000",
                    "sales": "130000",
                    "revenue": "45000",
                    "employees": "4",
                    "employeesHoursSum": "32"
                }]
            }
        }, {
            "store": {
                "storeId": "3000",
                "storeName": "Store 3",
                "storePhone": "+1 99 555-1234567",
                "storeAddress": "Elm Street",
                "storeCity": "New York"
            },
            "data": {
                "startDate": "2013-07-01",
                "endDate": "2013-07-02",
                "costTotal": "2400000",
                "salesTotal": "3800000",
                "revenueTotal": "1400000",
                "averageEmployees": "25.5",
                "averageEmployeesHours": "42",
                "dayData": [{
                    "date": "2013-07-01",
                    "cost": "1200000",
                    "sales": "1600000",
                    "revenue": "400000",
                    "employees": "23",
                    "employeesHoursSum": "41"
                }, {
                    "date": "2013-07-02",
                    "cost": "1200000",
                    "sales": "2200000",
                    "revenue": "1000000",
                    "employees": "28",
                    "employeesHoursSum": "43"
                }]
            }
        }, {
            "store": {
                "storeId": "4000",
                "storeName": "Store 4",
                "storePhone": "0044 34 123-45678",
                "storeAddress": "Churchill avenue",
                "storeCity": "London"
            },
            "data": {
                "startDate": "2013-07-01",
                "endDate": "2013-07-02",
                "costTotal": "1700000",
                "salesTotal": "2300000",
                "revenueTotal": "600000",
                "averageEmployees": "13.0",
                "averageEmployeesHours": "39",
                "dayData": [{
                    "date": "2013-07-01",
                    "cost": "850000",
                    "sales": "1170000",
                    "revenue": "320000",
                    "employees": "14",
                    "employeesHoursSum": "39"
                }, {
                    "date": "2013-07-02",
                    "cost": "850000",
                    "sales": "1130000",
                    "revenue": "280000",
                    "employees": "12",
                    "employeesHoursSum": "39"
                }]
            }
        }, {
            "store": {
                "storeId": "5000",
                "storeName": "Store 5",
                "storePhone": "+33 78 432-98765",
                "storeAddress": "Le Big Mac Rue",
                "storeCity": "Paris"
            },
            "data": {
                "startDate": "2013-07-01",
                "endDate": "2013-07-02",
                "costTotal": "1900000",
                "salesTotal": "2500000",
                "revenueTotal": "600000",
                "averageEmployees": "16.0",
                "averageEmployeesHours": "37",
                "dayData": [{
                    "date": "2013-07-01",
                    "cost": "950000",
                    "sales": "1280000",
                    "revenue": "330000",
                    "employees": "16",
                    "employeesHoursSum": "37"
                }, {
                    "date": "2013-07-02",
                    "cost": "950000",
                    "sales": "1220000",
                    "revenue": "270000",
                    "employees": "16",
                    "employeesHoursSum": "37"
                }]
            }
        }, {
            "store": {
                "storeId": "6000",
                "storeName": "Store 6",
                "storePhone": "+49 54 7624214",
                "storeAddress": "Bier strasse",
                "storeCity": "Berlin"
            },
            "data": {
                "startDate": "2013-07-01",
                "endDate": "2013-07-02",
                "costTotal": "1800000",
                "salesTotal": "2200000",
                "revenueTotal": "400000",
                "averageEmployees": "11.0",
                "averageEmployeesHours": "39",
                "dayData": [{
                    "date": "2013-07-01",
                    "cost": "900000",
                    "sales": "1100000",
                    "revenue": "200000",
                    "employees": "12",
                    "employeesHoursSum": "39"
                }, {
                    "date": "2013-07-02",
                    "cost": "900000",
                    "sales": "1100000",
                    "revenue": "200000",
                    "employees": "10",
                    "employeesHoursSum": "39"
                }]
            }
        }],
        "_links": {
            "self": {
                "href": "/storedata/between/2013-07-01/2013-07-02"
            }
        }
    };

})

