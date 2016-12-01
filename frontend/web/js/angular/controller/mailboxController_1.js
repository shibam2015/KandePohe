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
    $scope.mailboxDetais = {
        test: 'test'
    };
    $scope.inboxAll = '';
    //local variable
    //Scope Function declaretion
    $scope.init = init;
    $scope.student = tabAll;

    function init() {
        window.alert("hi!");
    }

    function tabAll() {
        var av = vService.ajaxWithOutNotification({
            url: 'all',
            data: {'Type': 'Inbox'}
        });
        console.log(av);
    }
});
