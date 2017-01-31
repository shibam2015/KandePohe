//Module..........
var app = angular.module('privacyApp', ['myCommonApp']);

//Configuration......
app.config(['$httpProvider', function ($httpProvider) {

}]);

//run...........
app.run(function run($http) {
    // $http.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name=csrf-token]').content;
});

//Controller............
app.controller('privacyController', function ($scope, vService, $http) {
    //scope Variable
    $scope.dashboardDetais = {
        firstname: 'Vix',
        lastname: 'Smart'
    }
    //local variable
    //Scope Function declaretion
    $scope.init = init;
    $scope.savePhonePrivacy = savePhonePrivacy;
    $scope.savePhotoPrivacy = savePhotoPrivacy;
    $scope.saveVisitorPrivacy = saveVisitorPrivacy;

    function init() {
        console.log("In...");
    }

    init();
    function savePhonePrivacy() {
        var phone_privacy = $scope.phone_privacy;
        vService.ajaxWithNotificationFlash({
            url: 'save-privacy-option',
            data: {'phone_privacy': phone_privacy, 'ACTION': 'PRIVACY-PHONE'}
        });
    }

    function savePhotoPrivacy() {
        var photo_privacy = $scope.photo_privacy;
        vService.ajaxWithNotificationFlash({
            url: 'save-privacy-option',
            data: {'photo_privacy': photo_privacy, 'ACTION': 'PRIVACY-PHOTO'}
        });
    }

    function saveVisitorPrivacy() {
        var visitor_setting = $scope.visitor_setting;
        vService.ajaxWithNotificationFlash({
            url: 'save-privacy-option',
            data: {'visitor_setting': visitor_setting, 'ACTION': 'PRIVACY-VISITOR'}
        });
    }
});