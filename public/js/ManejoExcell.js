angular.module('ManejoExcell', []).service('ManejoExcell', function () {

        this.exportarExcell = function(archivo, nombreHoja, nombreArchivo){
        var data = angular.copy(archivo);

        /* generate a worksheet */
        var ws = XLSX.utils.json_to_sheet(data);
            var wscols = [
                { hidden: true },
                { wch: 10 },
                { wch: 15 },
                { wch: 15 },
                { wch: 10 },
                { hidden: true }
            ];

            ws['!cols'] = wscols;

        /* add to workbook */
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, nombreHoja);

        /* write workbook (use type 'binary') */
        var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

        /* generate a download */
        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;
        }


        var blob = new Blob([s2ab(wbout)], { type: "application/octet-stream" });
        saveAs(blob, nombreArchivo+".xlsx");
        }
    })

    .directive("importSheetJs",  function () {
    return {
        scope: false,
        link: function ($scope, $elm, $attrs) {
            $elm.on('change', function (changeEvent) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    /* read workbook */
                    var bstr = e.target.result;
                    var workbook = XLSX.read(bstr, {
                        type: 'binary'
                    });
                    /* grab first sheet */
                    var wsname = workbook.SheetNames[0];
                    var ws = workbook.Sheets[wsname];
                    /* grab first row and generate column headers */
                    var aoa = XLSX.utils.sheet_to_json(ws, {
                        header: 1,
                        raw: false
                    });

                    var data = [];
                    for (var r = 1; r < aoa.length; ++r) {
                        data[r - 1] = {};
                        for (i = 0; i < aoa[r].length; ++i) {
                            if (aoa[r][i] == null) continue;
                            data[r - 1][aoa[0][i]] = aoa[r][i]
                        }
                    }
                    /* update scope */
                    $scope.$apply(function () {
                        $scope.archivoExcell = data;
                        $scope.modificarDatos();
                    });
                    /* DO SOMETHING WITH workbook HERE */
                };

                reader.readAsBinaryString(changeEvent.target.files[0]);

            });
        }
    };
})

.directive("modalExport", function () {
    return {
        template: 
            '<div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
                '<div class="modal-dialog" role="document">'+
                    '<div class="modal-content">'+
                        '<div class="modal-header">'+
                            '<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>'+
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                        '</div>'+
                        '<div class="modal-body">'+
                            '...'+
                        '</div>'+
                        '<div class="modal-footer">'+
                            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
                            '<button type="button" class="btn btn-primary">Save changes</button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'
    };
});
