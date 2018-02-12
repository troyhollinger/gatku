app.controller('HearGoodStuffController', ['$scope', 'HearGoodStuff', function($scope, HearGoodStuff) {

	$scope.email_address = '';

	$scope.addEmailToMailingList = function() {
        HearGoodStuff.store({email: $scope.email_address});
	}
}]);