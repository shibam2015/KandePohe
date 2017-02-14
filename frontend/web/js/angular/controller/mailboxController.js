//Module..........
var app = angular.module('mailboxApp', ['myCommonApp']);

//Configuration......
app.config(['$httpProvider', function ($httpProvider) {

}]);

//run...........
app.run(function run($http) {
    //$http.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name=csrf-token]').content;
});

//Controller............
app.controller('mailboxController', function ($scope, vService, $http) {

    //scope Variable
    $scope.mailboxDetais = {
        test: 'test'
    };
    $scope.inboxAll = '';
    $scope.loader = '';
    //local variable
    //Scope Function declaretion
    $scope.init = init;

    function init() {
        console.log("In...m");
    }

    init();

});
