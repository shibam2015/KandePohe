//Module..........
var commonApp = angular.module('myCommonApp', []);

//run...........
commonApp.run(function run($http) {
    $http.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name=csrf-token]').content;
});

//factory code
commonApp.factory('vService', ['$http', function($http) {
    return {
        ajaxWithnotification: function(commonObj) {
	  		$http({
	            method: "POST",
	            url: commonObj.url,
	            data: commonObj.data,
	        }).then(function mySucces(response) {
	        	notificationPopup(response.data.STATUS, response.data.MESSAGE);
	        }, function myError(response) {
	            notificationPopup('ERROR', 'Something went wrong. Please try again !');
	        });
		},
		ajaxWithNotificationFlash: function (commonObj) {
			$http({
				method: "POST",
				url: commonObj.url,
				data: commonObj.data,
			}).then(function mySucces(response) {
				showNotification(response.data.STATUS, response.data.MESSAGE);
			}, function myError(response) {
				showNotification('ERROR', 'Something went wrong. Please try again !');
			});
		},
		ajaxWithOutNotification: function (commonObj) {
			$http({
				method: "POST",
				url: commonObj.url,
				data: commonObj.data,
			}).then(function mySucces(response) {
				return response.data;
			}, function myError(response) {
				notificationPopup('ERROR', 'Something went wrong. Please try again !');
			});
		}
    };
}]);
