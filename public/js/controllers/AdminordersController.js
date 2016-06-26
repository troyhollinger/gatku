app.controller('AdminordersController', ['$scope', 'Order','$http', function($scope, Order, $http) {

	var gatkuOrder = this;
    gatkuOrder.orders = []; 
    gatkuOrder.pageno = 1; 
    gatkuOrder.itemsPerPage = 15; 
    gatkuOrder.getData = function(pageno){ 
        gatkuOrder.orders = [];  $http.get("/orderall/" + gatkuOrder.itemsPerPage + "/" + pageno).success(function(response){
            $scope.orders = response.data;
            gatkuOrder.orders = response.data;
            gatkuOrder.total_count = response.total_count;
        });
    };
    gatkuOrder.getData(gatkuOrder.pageno); 
    

}]);



