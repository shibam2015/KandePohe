//Module..........
var app = angular.module('myApp', ['myCommonApp']);

//Configuration......
app.config(['$httpProvider', function ($httpProvider) {

}]);

//run...........
app.run(function run($http) {
    $http.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name=csrf-token]').content;
});

//Controller............
app.controller('mailboxController', function ($scope, vService, $http) {

    //scope Variable
    $scope.dashboardDetais = {
        test: 'test'
    }
    //local variable

    //Scope Function declaretion
    $scope.init = init;
    $scope.changePrivacy = changePrivacy;

    function init() {

    }

    function changePrivacy() {
        var user_privacy_option = $scope.user_privacy_option;
        vService.ajaxWithnotification({
            url: 'saveprivacy-setting',
            data: {'user_privacy_option': user_privacy_option, 'ACTION': 'Save'}
        });
    }
});