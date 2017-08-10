var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('cobrar', function($scope, $http, $compile, $sce, NgTableParams, $filter) {
   
// ESTAS FUNCIONES SON PARA DEFINIR LOS PARAMETROS DE BUSQUEDA EN LA FUNCION QUERY
   $scope.buscandoSocios = function(searchText)
   {
      $scope.campoSocio = 'socios.nombre';
      $scope.campoOrganismo = 'organismos.id';
      $scope.campoProovedor = 'proovedores.id';
      $scope.campoProducto = 'movimientos.id_producto';
      $scope.operadorSocio = 'LIKE';
      $scope.operadorOrganismo = '=';
      $scope.operadorProovedor = '=';
      $scope.operadorProducto = '=';
      $scope.valorOrganismo = $scope.organismo == null ? '' : $scope.organismo.id_organismo;
      $scope.valorSocio = '%'+searchText+'%';
      $scope.valorProovedor = $scope.proovedor == null ? '' : $scope.proovedor.id_proovedor;
      $scope.valorProducto = $scope.producto == null ? '' : $scope.producto.id_producto;
      $scope.groupBy = 'socio';
   }

   $scope.buscandoOrganismos = function(searchText)
   {
      $scope.campoOrganismo = 'organismos.nombre';
      $scope.campoSocio = 'movimientos.id_asociado';
      $scope.campoProovedor = 'proovedores.id';
      $scope.campoProducto = 'movimientos.id_producto';
      $scope.operadorOrganismo = 'LIKE';
      $scope.operadorProovedor = '=';
      $scope.operadorProducto = '=';
      $scope.operadorSocio = '=';
      $scope.valorOrganismo = '%'+searchText+'%';
      $scope.valorSocio = $scope.socio == null ? '' : $scope.socio.id_asociado;
      $scope.valorProovedor = $scope.proovedor == null ? '' : $scope.proovedor.id_proovedor;
      $scope.valorProducto = $scope.producto == null ? '' : $scope.producto.id_producto;
      $scope.groupBy = 'organismo';
   }

   $scope.buscandoProovedores = function(searchText)
   {
      $scope.campoSocio = 'movimientos.id_asociado';
      $scope.campoProovedor = 'proovedores.nombre';
      $scope.campoProducto = 'movimientos.id_producto';
      $scope.campoOrganismo = 'organismos.id';
      $scope.operadorProovedor = 'LIKE';
      $scope.operadorOrganismo = '=';
      $scope.operadorProducto = '=';
      $scope.operadorSocio = '=';
      $scope.valorProovedor = '%'+searchText+'%';
      $scope.valorOrganismo = $scope.organismo == null ? '' : $scope.organismo.id_organismo;
      $scope.valorSocio = $scope.socio == null ? '' : $scope.socio.id_asociado;
      $scope.valorProducto = $scope.producto == null ? '' : $scope.producto.id_producto;
      $scope.groupBy = 'proovedor';
   }

   $scope.buscandoProductos = function(searchText)
   {
      $scope.campoSocio = 'movimientos.id_asociado';
      $scope.campoOrganismo = 'organismos.id';
      $scope.campoProovedor = 'proovedores.id';
      $scope.campoProducto = 'productos.nombre';
      $scope.operadorProducto = 'LIKE';
      $scope.operadorSocio = '=';
      $scope.operadorOrganismo = '=';
      $scope.operadorProovedor = '=';
      $scope.valorProoducto = '%'+searchText+'%';
      $scope.valorOrganismo = $scope.organismo == null ? '' : $scope.organismo.id_organismo;
      $scope.valorSocio = $scope.socio == null ? '' : $scope.socio.id_asociado;
      $scope.valorProovedor = $scope.proovedor == null ? '' : $scope.proovedor.id_proovedor;
      $scope.groupBy = 'producto';
   }
// FIN DE FUNCIONES

   // ESTA FUNCION ES LA QUE HACE LA BUSQUEDA PARA EL AUTOCOMPLETE
  $scope.query = function(searchText, ruta)
   {
      var proovedor, socio, producto;
      proovedor = $scope.proovedor == null ? '' : $scope.proovedor.id;
      socio = $scope.socio == null ? '' : $scope.socio.id;
      producto = $scope.producto == null ? '' : $scope.producto.id;

      return $http({
         url: 'movimientos/datosAutocomplete',
         method: 'post',
         data: {'filtros': [{'campo': $scope.campoProovedor, 'valor': $scope.valorProovedor, 'operador': $scope.operadorProovedor}, {'campo': $scope.campoSocio, 'valor': $scope.valorSocio, 'operador': $scope.operadorSocio}, {'campo': $scope.campoProducto, 'valor':$scope.valorProducto, 'operador': $scope.operadorProducto}, {'campo': $scope.campoOrganismo, 'valor':$scope.valorOrganismo, 'operador': $scope.operadorOrganismo} ], 'groupBy': $scope.groupBy}
         }).then(function successCallback(response)
            {
               console.log(response.data.movimientos);
               if(typeof response.data == 'string')
               {
                  return [];
               }
               else
               {
                  return response.data.movimientos;
               }

            }, function errorCallback(data)
            {
               console.log(data.data);
            });
   }

   // DATOS PARA FILTRAR LA DATATABLE 
   $scope.data = [
      {'campo': 'movimientos.id_asociado', 'valor': $scope.valorSocio, 'operador': '='},
      {'campo': 'movimientos.id_producto', 'valor': $scope.valorProducto, 'operador': '='},
      {'campo': 'proovedores.id', 'valor': $scope.valorProovedor, 'operador': '='}, 
      {'campo': 'organismos.id', 'valor': $scope.valorOrganismo, 'operador': '='},
      {'campo': 'importeTotal', 'valor':$scope.minimo_importe, 'operador': '>='},
      {'campo': 'importeTotal', 'valor':$scope.maximo_importe, 'operador': '<='},
      {'campo': 'cuotas.importe', 'valor':$scope.minimo_importe_cuota, 'operador': '>='},
      {'campo': 'cuotas.importe', 'valor':$scope.maximo_importe_cuota, 'operador': '<='},
      {'campo': 'cuotas.nro_cuota', 'valor':$scope.minimo_nro_cuota, 'operador': '>='},
      {'campo': 'cuotas.nro_cuota', 'valor':$scope.maximo_nro_cuota, 'operador': '<='},
      {'campo': 'cuotas.fecha_pago', 'valor':$scope.desde, 'operador': '>='},
      {'campo': 'cuotas.fecha_pago', 'valor':$scope.hasta, 'operador': '<='}
   ];
   $scope.cobrarSocio = false;
   $scope.cobrarVenta = false;
    $("#cobrarSocio").hide();
    $("#cobrarVenta").hide();
   // TABLA DE LA DATATABLE  


   $('#tablaOrganismos tbody').on( 'click', 'tr', function () {
       $("#cobrarSocio").show();

            var id = tabla.row(this).data().id_organismo;
         $('#tablaOrganismos').dataTable().fnDestroy();
         $('#tablaOrganismos').remove();
         var $div = $("<table>", {"class": "table table-striped table-bordered dt-responsive nowrap order-colum compact", id: "tablaSocios", });
         $('#paraBorrar').append($div);
         var tfoot = $("<tfoot>");
         $('#tablaSocios').append(tfoot);
         var html = '<tr><th style="text-align:right">Total:</th><th></th><th></th></tr>';
         $('tfoot').append(html);
         $scope.tabla2 =  $("#tablaSocios").DataTable({
         processing: true,
         serverSide: true,
         ajax:
         {
            url:"cobrar/porSocio",
            type: "POST",
            headers:
            {
               'X-CSRF-TOKEN': $('#token').val()
            },
            data: function (d)
            {
               d.filtros = $scope.data;
               d.id = id;
            }
         },
         createdRow: function ( row, data, index ) {
              
            if ( parseFloat(data.deuda) * 1 > 0 ) {
                $('td', row).eq(6).addClass('highlight');
            }

            $(row).find('input').attr('id', 'input'+data.id_socio);
      
        },   
         columnDefs: 
         [
            { "title": "Socio", "targets": 0 },
            { "title": "Monto a cobrar", "targets": 1 },

         ],
         columns: 
         [

            {data: 'socio', name: 'socio'},

            {data: 'diferencia', name: 'diferencia'},
            {defaultContent: '<input type="number">'},
            
         ],
         footerCallback: function ( row, data, start, end, display )
         {
            var api = this.api(), data;
  
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) 
            {
               return typeof i === 'string' ?
               i.replace(/[\$,]/g, '')*1 :
               typeof i === 'number' ?
               i : 0;
            };
    
            // Total over this page
              totalACobrars = api
               .column( 1, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

               total = api
               .column( 2, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

                 $( api.column( 1 ).footer() ).html(
               '$'+totalACobrars
            );


          
         },
         select: true,
         fixedHeader: 
         {
            header:true,
            footer: true,
         },
         language: 
         {
            info: "Mostrando del _PAGE_ al _END_ de _TOTAL_ registros",
            zeroRecords: "No se encontraron resultados",
            infoFiltered: "(filtrado de _MAX_ registros)",
            lengthMenu: "Mostrar _MENU_ registros",
            paginate: 
            {
               next: "Siguiente",
               previous: "Anterior"
            },
            search: "Buscar:"
         },
            dom: 'Blrtip',
            buttons: 
            [
               {
                  extend: 'pdf',
                  text: 'Generar reporte',
                  exportOptions: 
                  {
                     columns: ':visible',
                     modifier:
                     {
                       page: 'current'
                     }
                  }
               },
               'print',
            ],
         lengthChange: true,
         aLengthMenu: [
           [25, 50, 100, 200, -1],
           [25, 50, 100, 200, "Todos"]
         ],
      });

   });

    $('#paraBorrar').on( 'click', '#tablaSocios tr', function () {
        $("#cobrarSocio").hide();
        $("#cobrarVenta").show();
        var id = $scope.tabla2.row(this).data().id_socio;
        $('#tablaSocios').dataTable().fnDestroy();
        $('#tablaSocios').remove();
        $scope.tabla2 = undefined;
        var $div = $("<table>", {"class": "table table-striped table-bordered dt-responsive nowrap order-colum compact", id: "tablaVentas", });
        $('#paraBorrar').append($div);
        var tfoot = $("<tfoot>");
        $('#tablaVentas').append(tfoot);
        var html = '<tr><th colspan="3" style="text-align:right">Total:</th><th></th><th></th></tr>';
        $('tfoot').append(html);
        $scope.tabla3 =  $("#tablaVentas").DataTable({
            processing: true,
            serverSide: true,
            ajax:
                {
                    url:"cobrar/mostrarPorVenta",
                    type: "POST",
                    headers:
                        {
                            'X-CSRF-TOKEN': $('#token').val()
                        },
                    data: function (d)
                    {
                        d.filtros = $scope.data;
                        d.id = id;
                    }
                },
            createdRow: function ( row, data, index ) {

                if ( parseFloat(data.diferencia) * 1 > 0 ) {
                    $('td', row).eq(6).addClass('highlight');
                }
                $(row).find('input').attr('id', 'input'+data.id_venta);
            },
            columnDefs:
                [
                    { "title": "Servicio", "targets": 0 },
                    { "title": "Socio", "targets": 1 },
                    { "title": "Proovedor", "targets": 2 },
                    { "title": "Monto a cobrar", "targets": 3 },

                ],
            columns:
                [
                    {data: 'id_venta', name:'id_venta'},
                    {data: 'socio', name: 'socio'},
                    {data: 'proovedor', name: 'proovedor'},
                    {data: 'diferencia', name: 'diferencia'},
                    {defaultContent: '<input type="number">'},


                ],
            footerCallback: function ( row, data, start, end, display )
            {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i )
                {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };



                deuda = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                $( api.column( 3 ).footer() ).html(
                    '$'+deuda
                );

            },
            select: true,
            fixedHeader:
                {
                    header:true,
                    footer: true,
                },
            language:
                {
                    info: "Mostrando del _PAGE_ al _END_ de _TOTAL_ registros",
                    zeroRecords: "No se encontraron resultados",
                    infoFiltered: "(filtrado de _MAX_ registros)",
                    lengthMenu: "Mostrar _MENU_ registros",
                    paginate:
                        {
                            next: "Siguiente",
                            previous: "Anterior"
                        },
                    search: "Buscar:"
                },
            dom: 'Blrtip',
            buttons:
                [
                    {
                        extend: 'pdf',
                        text: 'Generar reporte',
                        exportOptions:
                            {
                                columns: ':visible',
                                modifier:
                                    {
                                        page: 'current'
                                    }
                            }
                    },
                    'print',
                ],
            lengthChange: true,
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "Todos"]
            ],
        });

    });



   $scope.cobrar = function()
   {
      var p = $scope.tabla2.rows().data();
   
      var aux = [];
      for(var i=0; p.length > i; i++)
      {
        var valorInput = $('#input'+p[i].id_socio).val();
         if(valorInput > 0 )
         {
            p[i]['cobro'] = valorInput;
            aux.push(p[i]); 
         }
      }
      $http({
         url: 'cobrar/cobroPorPrioridad',
         method: 'post',
         headers: {'X-CSRF-TOKEN': $('#token').val()},
         data: aux
         }).then(function successCallback(response)
            {
               console.log(response.data);

            }, function errorCallback(data)
            {
               console.log(data.data);
            });
   }

   $scope.cobrarPorVenta = function()
   {
       var p = $scope.tabla3.rows().data();

       var aux = [];
       for(var i=0; p.length > i; i++)
       {
           var valorInput = $('#input'+p[i].id_venta).val();
           if(valorInput > 0 )
           {
               p[i]['cobro'] = valorInput;
               aux.push(p[i]);
           }
       }
       $http({
           url: 'cobrar/cobroPorVenta',
           method: 'post',
           headers: {'X-CSRF-TOKEN': $('#token').val()},
           data: aux
       }).then(function successCallback(response)
       {
           console.log(response.data);

       }, function errorCallback(data)
       {
           console.log(data.data);
       });
   }
   
   // ESTA FUNCION ES PARA FILTRAR LA DATATABLE
   $scope.filtro = function()
   {
      var desde = $scope.desde == undefined ? '' : formatearFecha($scope.desde.toLocaleDateString("es-ES"));
      var hasta = $scope.hasta == undefined ? '' : formatearFecha($scope.hasta.toLocaleDateString("es-ES"));

      $scope.valorSocio = $scope.socio == null ? '' : $scope.socio.id_asociado;
      $scope.valorProovedor = $scope.proovedor == null ? '' : $scope.proovedor.id_proovedor;
      $scope.valorProducto = $scope.producto == null ? '' : $scope.producto.id_producto;
      $scope.valorOrganismo = $scope.organismo == null ? '' : $scope.organismo.id_organismo;

      $scope.data = [
         {'campo': 'movimientos.id_asociado', 'valor': $scope.valorSocio, 'operador': '='},
         {'campo': 'movimientos.id_producto', 'valor': $scope.valorProducto, 'operador': '='},
         {'campo': 'proovedores.id', 'valor': $scope.valorProovedor, 'operador': '='},
         {'campo': 'organismos.id', 'valor': $scope.valorOrganismo, 'operador': '='}, 
         {'campo': 'importeTotal', 'valor':$scope.minimo_importe, 'operador': '>='},
         {'campo': 'importeTotal', 'valor':$scope.maximo_importe, 'operador': '<='},
         {'campo': 'cuotas.importe', 'valor':$scope.minimo_importe_cuota, 'operador': '>='},
         {'campo': 'cuotas.importe', 'valor':$scope.maximo_importe_cuota, 'operador': '<='},
         {'campo': 'cuotas.nro_cuota', 'valor':$scope.minimo_nro_cuota, 'operador': '>='},
         {'campo': 'cuotas.nro_cuota', 'valor':$scope.maximo_nro_cuota, 'operador': '<='},
         {'campo': 'cuotas.fecha_pago', 'valor':desde, 'operador': '>='},
         {'campo': 'cuotas.fecha_pago', 'valor':hasta, 'operador': '<='}
        ];
      tabla.draw();
   }

   $scope.llenar = function() {
          $http({
            url: 'cobrar/datos',
            method: 'post'
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.datosCobro = response.data;
                $scope.paramsCobro = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.datosCobro.length,
                    getData: function (params) {
                        $scope.datosCobro = $filter('orderBy')($scope.datosCobro, params.orderBy());
                        return $scope.datosCobro.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });
   }
   $scope.llenar();

  /* $scope.cobrar = function()
   {
      var cuotas_id = [];
      $('#datatable-responsive > tbody > tr.selected').each(function (tr){
         cuotas_id.push(tabla.row(tr).data().id_cuota);
         console.log(tabla.row(tr).data().id_cuota);
      });
         
         $http({
         url: 'cobrar/cobrarCuotas',
         method: 'post',
         data: {'cuotas': cuotas_id}
         }).then(function successCallback(response)
            {
               console.log(response.data.movimientos);
               if(typeof response.data == 'string')
               {
                  return [];
               }
               else
               {
                  return response.data.movimientos;
               }

            }, function errorCallback(data)
            {
               console.log(data.data);
            });
   }*/
});

