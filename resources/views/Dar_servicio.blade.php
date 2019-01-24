@extends('welcome') @section('contenido') {!! Html::script('js/controladores/Dar_servicio.js') !!}

<div class="nav-md" ng-controller="Dar_servicio">
    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" type="hidden" value="asociados">
            <!-- page content -->
            <div class="left-col" role="main">
                <div class="">
                    <div class="clearfix">
                    </div>
                    <div class="row">
                        @if(Sentinel::check()->hasAccess('darServicios.visualizar'))
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="mensaje"></div>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>
                                        Otorgar servicio

                                    </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up">
                                                </i>
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown"
                                               href="#" role="button">
                                                <i class="fa fa-wrench">
                                                </i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="#">
                                                        Settings 1
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Settings 2
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="close-link">
                                                <i class="fa fa-close">
                                                </i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix">
                                    </div>
                                </div>
                                <div class="x_content">
                                    <form class=" form-label-left" ng-submit="crearMovimiento()">
                                        <md-autocomplete class="" md-input-name="idafiliado"
                                                         md-item-text="item.nombre+' (' + item.legajo + ')'"
                                                         md-items="item in query(searchText, 'filtroSocios')"
                                                         md-search-text="searchText" md-selected-item="socio"
                                                         md-min-length="0" placeholder="Buscar afiliado..."
                                                         required>
                                            <span md-highlight-text="searchText" ng-cloak>
                                                {[{item.nombre}]} {[{item.apellido}]} ({[{item.legajo}]})
                                            </span>
                                        </md-autocomplete>
                                        <hr/>
                                        <md-autocomplete class="" md-input-name="idafiliado"
                                                         md-item-text="item.razon_social"
                                                         md-items="item in query(searchText2, 'filtroProovedores')"
                                                         md-search-text="searchText2" md-selected-item="proovedor"
                                                         md-selected-item-change="habilitar()"
                                                         placeholder="Buscar proovedor..." md-min-length="0" required>
                                            <span md-highlight-text="searchText" ng-cloak>
                                                {[{item.razon_social}]}
                                            </span>
                                        </md-autocomplete>
                                        <hr/>
                                        <md-autocomplete class="" md-input-name="idafiliado" md-item-text="item.nombre"
                                                         md-items="item in traerProductos(searchText3)"
                                                         md-search-text="searchText3" md-selected-item="producto"
                                                         ng-disabled="habilitacion"
                                                         placeholder="Buscar producto..." required md-min-length="0">
                                            <span md-highlight-text="searchText" ng-cloak>
                                                {[{item.nombre}]}
                                            </span>

                                        </md-autocomplete>

                                        <hr/>

                                        <div class="row form-group">
                                            <div class="">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="cuotas">
                                                    Cuotas
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" name="cuotas" ng-change="getImporte()"
                                                           placeholder="12" ng-model="nro_cuotas" type="number" required>
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12"
                                                       for="observacion">
                                                    Observacion
                                                </label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" id="observacion"
                                                           name="observacion" ng-model="observacion" type="text"
                                                           placeholder="Ingrese una observacion">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class=" ">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="capital">
                                                    Monto por cuota
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" name="capital"
                                                           placeholder="123" ng-model="montoPorCuota" type="number" ng-change="getImporte()"
                                                           step="0.01" required>
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12"
                                                       for="vencimiento">
                                                    Vencimiento
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" id="vencimiento"
                                                           name="vencimiento" ng-model="vencimiento" type="date"
                                                           required>
                                                    </input>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row form-group ">
                                            <label class="control-label  col-md-1 col-sm-3 col-xs-12">
                                                Importe otorgado
                                            </label>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12"
                                                       ng-model="importe_otorgado" type="number" placeholder="123"/>
                                            </div>
                                            <label class="control-label  col-md-1 col-sm-3 col-xs-12">
                                                Capital total
                                                <span class="required">
                                                    *
                                                </span>
                                            </label>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12" ng-model="importe"
                                                       type="number" disabled>

                                                </input>
                                            </div>

                                        </div>

                                        <div class="row form-group" ng-if="tipo_servicio == 'credito'" ng-cloak>
                                            <div class="item">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12"
                                                       for="plata recibida">
                                                    Monto Total Otorgado
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" name="monto_total"
                                                           ng-model="monto_total" type="number" required>
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="" ng-show="tipo_servicio == 'credito'">
                                                <label class="control-label col-md-offset-1 col-md-1 col-sm-3 col-xs-12"
                                                       for="ncredito">
                                                    N° de Credito
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" name="ncredito"
                                                           ng-model="ncredito" type="text" required>
                                                    </input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group" ng-if="tipo_servicio == 'producto'" ng-cloak>
                                            <div class="item">
                                                <label class="control-label col-md-1 col-sm-3 col-xs-12"
                                                       for="observaciones">
                                                    Observaciones

                                                </label>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" name="observaciones"
                                                           ng-model="observaciones" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="item form-group" style="margin-top:20px;">
                                                <div class="">
                                                    <button class="btn btn-primary" data-target="#planDePago"
                                                            data-toggle="modal" ng-click="mostrarPlanDePago()"
                                                            type="button">
                                                        Plan de pago
                                                    </button>
                                                    @if(Sentinel::check()->hasAccess('darServicios.crear'))
                                                    <button class="btn btn-success" id="send" type="submit">
                                                        Alta
                                                    </button>
                                                    <button class="btn btn-success" id="send" type="button" ng-click="generarArchivo()">
                                                        imprimir
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row" ng-show="mostrar">
                                        <table class="table striped" ng-cloak>
                                            <thead>
                                            <tr>
                                                <th>Cuota</th>
                                                <th>Importe</th>
                                                <th>Vencimiento</th>
                                            </tr>

                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="x in planDePago">
                                                <td>{[{x.cuota}]}</td>
                                                <td>{[{x.importe}]}</td>
                                                <td>{[{x.fecha}]}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">
                                ×
                            </button>
                            <h4 class="modal-title">
                                Modal Header
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p>
                                Some text in the modal.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN Modal -->
            </input>
        </div>
    </div>
    <div class="custom-notifications dsp_none" id="custom_notifications">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix">
        </div>
        <div class="tabbed_notifications" id="notif-group">
        </div>
    </div>


    <div style="display: none">
        <div id="archivoImprimir">
        
            <div id="pagina2" style="height:297mm;width:210mm; margin:10mm">
                <div class="Section3" style="clear: both; page-break-before: always">
                    <div class="row" style="display:flex">
                        <div class="col">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:0pt;margin-bottom:0pt;margin-left:5pt;"><img
                                    src="images/archivoSocio/MTaLxPbX_img4.png" width="134" height="81" alt="" /></p>
                        </div>
                        <div class="col mr-3" style="width:100%">
                            <div class="row justify-content-end">
                                <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:normal;margin-top:5pt;margin-bottom:0pt;margin-left:128.3pt;"></p>
                            </div>
                            <div class="row justify-content-end">
                                <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:0pt;margin-bottom:0pt;"><span
                                        style="font-family:Arial;font-size:16pt;text-transform:none;font-weight:bold;font-style:normal;font-variant:normal;">Asociación
                                        Mutual 27 de Junio</span></p>
                            </div>
                            <div class="row justify-content-end">
                                <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:15.6pt;margin-top:0pt;margin-bottom:0pt;margin-left:120.65pt;"><span
                                        style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:15.6pt;">Matrícula
                                        Nº 1810</span></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="border: 1px solid black!important;">
                        <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13.5pt;margin-top:0pt;margin-bottom:0pt;margin-left:115.65pt;margin-right:8.45pt;"><span
                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">Buenos
                                Aires, {[{diaHoy}]} de {[{mesHoy}]} del {[{anioHoy}]}</span></p>
                        <p style="text-align:center;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13.5pt;margin-top:0pt;margin-bottom:0pt;margin-left:115.65pt;margin-right:8.45pt;"><span
                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">&#xa0;</span></p>
                        <div class="Section4">
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:7pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:7pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:7pt;">&#xa0;</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                            <p style="text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115.833328%;margin-top:1.45pt;margin-bottom:0pt;margin-left:5pt;text-indent:3.4pt;margin-right:4.9pt;"><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;mso-spacerun:yes;">.                  
                                </span><span style="letter-spacing:1.55pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Por
                                    la </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">presente
                                    autorizo a deducir de mis haberes {[{numberToString(nro_cuotas)}]} ({[{nro_cuotas}]})
                                    cuotas
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mensuale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">iguale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                    y </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">consecutiva</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de Pesos {[{numberToString(montoPorCuota)}]}, con {[{decimalToString(montoPorCuota)}]} centavos
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">(${[{montoPorCuota}]}</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">)
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">un</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">en
                                    concepto de  {[{proovedor.razon_social}]} {[{producto.nombre}]}
                                </span><span style="letter-spacing:0.8pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">por Pesos {[{numberToString(importe)}]}, con {[{decimalToString(importe)}]} centavos ($ {[{importe}]}).</span></p>
                            <p style="text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115.833328%;margin-top:0.05pt;margin-bottom:0pt;margin-left:5pt;text-indent:7pt;margin-right:3.3pt;"><span
                                    style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cas</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">licenci</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">extraordinari</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                    o </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ces</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">labora</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">en {[{socio.organismo.nombre}]} autoriz</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                    a </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mism</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                    a </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">desconta</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mi</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habere</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">suma</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pendiente</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">adeud</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                    a </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIACIO</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">N
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">MUTUA</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">2</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">DE
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">JUNI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                    y </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cas</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">hubier</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">indemnizacio</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">procede</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                    a </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">retencio</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">tota</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sumas
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pendiente</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                    a </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">nombrad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Mutual</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">S</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">i
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">fuer</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cas</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">m</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">compromet</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                    a </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">hace</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efectiv</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">el
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">oficina</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIACIO</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">N
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">MUTUA</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">2</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">D</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">JUNI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                    1 </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                    5 </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mes</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Tomo
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">conocimient</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">falt</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">do</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cuota</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mensuale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">consecutiva</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">produc</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">caducida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">del
                                    plaz</span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acordado</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">quedand</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">autorizad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIACIO</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">N
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">MUTUA</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">2</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">D</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">JUNI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">par</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">procede</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                    a </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ejecucio</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">judicia</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sald</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">deudor</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">co</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ma</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">gasto</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ocacione</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">dicha</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acciones</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.35pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">La
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIACIO</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">N
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">MUTUA</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">2</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">D</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">JUNI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">compromete</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">:
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">)
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">informa</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ASOCIAD</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.45pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">ha
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">percibid</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">import</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cuota</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">servici</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de {[{proovedor.razon_social}]}</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mediant</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sistem</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">retención
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habere</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">y/</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">otorgant</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Códig</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Descuento</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cumpl</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">co</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mismas</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">;
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">b</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">)
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">no
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">informa</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                    a </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">base</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">dato</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">deudore</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sistem</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">financier</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">morosida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">asociado</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.4pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sin
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acredita</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">previament</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mor</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">imputabl</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habers</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">podid</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efectiviza</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">descuent</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cuot</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">amortizació</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">préstamo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">;
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">c</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">)
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">informa</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cantida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cuota</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.3pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">servicio 
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">percibida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">asociado</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                    y </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">transferida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                    a </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">tercera</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">entidades</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">previ</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                    a </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">promoció</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acciones
                                    judiciale</span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">y/</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">extrajudiciale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">cobro</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">caso</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">SERVICI</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">O
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">prest</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                    a </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">travé</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">sistema
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">retenció</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.65pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habere</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">E</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">L
                                </span><span style="letter-spacing:0.65pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">DEUDOR</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">recib</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">habere</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">co</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">constanci</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.2pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">descuento
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efectuad</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">po</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">es</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">concepto</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pose</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">valo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">probatori</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">pag</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efectuado</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                    A </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">efecto</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.1pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">mencionados
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qued</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">elegid</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">competenci</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">lo</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Tribunale</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Ciuda</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Autonom</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Bueno</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Aires</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">.
                                </span><span style="letter-spacing:0.15pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Declaro
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">formula</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">a
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">present</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">solicitu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acuerd</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">co</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">n
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">la</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">condicione</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">reglamentaria</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">s
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">qu</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">manifiest</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">conocer
                                </span><span style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">y</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">acepta</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">r</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">conformida</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">d</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">com</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">part</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">present</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">documento</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">,</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">conform</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">e</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">articul</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">o</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">119</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">7</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">de</span><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">l</span><span
                                    style="letter-spacing:0.25pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">
                                </span><span style="letter-spacing:0.05pt;font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Codigo</span></p>
                            <p style="text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13.5pt;margin-top:0.05pt;margin-bottom:0pt;margin-left:5pt;margin-right:515.2pt;"><span
                                    style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13.5pt;">Civil.-</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:10pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:10pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:10pt;">&#xa0;</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:13pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13pt;">&#xa0;</span></p>
                            <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:13pt;margin-top:0pt;margin-bottom:0pt;"><span
                                    style="font-family:Arial;font-size:13pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:13pt;">&#xa0;</span></p>
                        </div>
                        <div class="Section5">
                            <div class="row m-3">
                                <div class="col">
                                    <div class="row">
                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115.833328%;margin-top:1.45pt;margin-bottom:0pt;margin-left:8.35pt;margin-right:16.7pt;"><span
                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Aclaracion: {[{socio.apellido}]} {[{socio.nombre}]}</span></p>
                                    </div>
                                    <div class="row">
                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115.833328%;margin-top:1.45pt;margin-bottom:0pt;margin-left:8.35pt;margin-right:16.7pt;"><span
                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115.833328%;">Legajo/
                                                Beneficio N°: {[{socio.legajo}]}</span></p>
                                    </div>
                                    <div class="row">
                                        <p style="text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:0.05pt;margin-bottom:0pt;margin-left:8.35pt;margin-right:-2.8pt;"><span
                                                style="font-family:Arial;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">Tipo
                                                y N° de Doc: DNI {[{socio.dni}]}</span></p>
                                    </div>
                                </div>
                                <div class="col">
                                    <p style="text-align:right;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:0pt;margin-bottom:0pt;"><span
                                            style="font-family:Arial;font-size:14pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;mso-spacerun:yes;">Firma
                                            del Titular</span>&emsp;&emsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection

