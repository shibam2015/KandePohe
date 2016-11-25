//Module..........
var app = angular.module('myApp', []);

//Configuration......
app.config(['$httpProvider', function ($httpProvider) {
	
}]);

//run...........
app.run(function run($http) {
    $http.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name=csrf-token]').content;
});

//Controller............
app.controller('dashboardController', function ($scope, $http) {

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
		
		$http({
            method: "POST",
            url: 'saveprivacy-setting',
            data: {'user_privacy_option': user_privacy_option,'ACTION': 'Save'},
        }).then(function mySucces(response) {
        	console.log(response.data);
            //var DataObject = JSON.parse(response);
          	//$('#photo_list').html(DataObject.OUTPUT);
        	notificationPopup(response.data.STATUS, response.data.MESSAGE);
        }, function myError(response) {
            notificationPopup('ERROR', 'Something went wrong. Please try again !');
        });
	}

});