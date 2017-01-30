//Module..........
var app = angular.module('myApp', ['myCommonApp']);

//Configuration......
app.config(['$httpProvider', function ($httpProvider) {
	
}]);

//run...........
app.run(function run($http) {
	// $http.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name=csrf-token]').content;
});

//Controller............
app.controller('dashboardController', function ($scope, vService, $http) {

	//scope Variable
	$scope.dashboardDetais = {
		firstname : 'Vishal',
		lastname : 'Bhalani'
	}
	//local variable

	//Scope Function declaretion
	$scope.init = init;
	$scope.changePrivacy = changePrivacy;

	function init() {

	}

	function changePrivacy() {
		var user_privacy_option = $scope.user_privacy_option;
		console.log(user_privacy_option);
		vService.ajaxWithNotificationFlash({
			url:'saveprivacy-setting',
			data:{'user_privacy_option': user_privacy_option,'ACTION': 'Save'}
		});
	}
});