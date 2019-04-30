export const generarTabla = (array) => {
    return new NgTableParams({
        page: 1,
        count: 10
    }, {
            getData: function (params) {
                var filterObj = params.filter();
                filteredData = $filter('filter')(array, filterObj);
                var sortObj = params.orderBy();
                orderedData = $filter('orderBy')(filteredData, sortObj)
                $scope.paramsReporte.total(orderedData.length);
                return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
            }
        });
}
