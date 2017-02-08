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
				url: [commonObj.url],
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
				var ck = angular.isUndefined(response.data.POPUPTYPE);
				var ck1 = angular.isUndefined(response.data.REDIRECTURL);
				if (ck != true || response.data.POPUPTYPE == 1) {
					notificationPopup(response.data.STATUS, response.data.MESSAGE);
				} else {
					showNotification(response.data.STATUS, response.data.MESSAGE);
				}
				if (ck1 != true) {
					setTimeout(function () {
						//window.location.href = response.data.REDIRECTURL;
						window.location.reload();
					}, 3000);

				}

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
