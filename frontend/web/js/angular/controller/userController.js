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
    $scope.IsVisible = false;
    function init() {
        // console.log("In...");
    }
    init();
    $scope.ShowReasonSection = function (value) {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = value == "4";
    }
    function multipleProfile() {
        var MultipleProfileStatus = $scope.multiple_profile_status;
        var MultipleProfileReason = $scope.multiple_profile_reason;
        vService.ajaxWithNotificationFlash({
            url: masterSiteUrl + 'user/multiple-profile-option',
            data: {
                'MultipleProfileStatus': MultipleProfileStatus,
                'MultipleProfileReason': MultipleProfileReason,
                'ACTION': 'MULTIPLE-PROFILE'
            }
        });

    }
});