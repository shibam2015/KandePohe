//Module..........
var app = angular.module('userApp', ['myCommonApp']);

//Configuration......
app.config(['$httpProvider', function ($httpProvider) {

}]);

//run...........
app.run(function run($http) {
    // $http.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name=csrf-token]').content;
});

//Controller............
app.controller('userController', function ($scope, vService, $http) {
    //scope Variable
    $scope.dashboardDetais = {
        firstname: 'Vix',
        lastname: 'Smart'
    }
    //local variable
    //Scope Function declaretion
    $scope.init = init;
    $scope.multipleProfile = multipleProfile;

    function init() {
        console.log("In...");
    }

    init();
    function multipleProfile() {
        var multiple_profile_status = $scope.multiple_profile_status;
        vService.ajaxWithNotificationFlash({
            url: 'multiple-profile-option',
            data: {'user_privacy_option': user_privacy_option, 'ACTION': 'Save'}
        });

    }
});