//module ........
var app = angular.module('myApp', []);

//congifrigrtion............
app.config(['$httpProvider', function ($httpProvider) {

}]);

//controller....
app.controller('userDetailController', function ($scope, $http, transformRequestAsFormPost) {

    //scope variable
    $scope.userDetailData = {
        detail: null,
        item: {'cancel': 0}
    };

    //local variable


    //scope function decalration
    $scope.init = init;
    $scope.myInfo = myInfo;

    function init(url) {
        myInfo(url, 1);
    }


    function myInfo(url, value) {
        $http({
            method: "POST",
            url: url,
            data: {'cancel': value},
        }).then(function mySucces(response) {
            $scope.myWelcome = response.data.infohtml;
        }, function myError(response) {
            $scope.myWelcome = response.statusText;
        });
    }

});


// I provide a request-transformation method that is used to prepare the outgoing
// request as a FORM post instead of a JSON packet.
app.factory(
    "transformRequestAsFormPost",
    function () {
        // I prepare the request data for the form post.
        function transformRequest(data, getHeaders) {
            var headers = getHeaders();
            headers["Content-type"] = "application/x-www-form-urlencoded; charset=utf-8";
            return ( serializeData(data) );
        }

        // Return the factory value.
        return ( transformRequest );
        // ---
        // PRVIATE METHODS.
        // ---
        // I serialize the given Object into a key-value pair string. This
        // method expects an object and will default to the toString() method.
        // --
        // NOTE: This is an atered version of the jQuery.param() method which
        // will serialize a data collection for Form posting.
        // --
        // https://github.com/jquery/jquery/blob/master/src/serialize.js#L45
        function serializeData(data) {
            // If this is not an object, defer to native stringification.
            if (!angular.isObject(data)) {
                return ( ( data == null ) ? "" : data.toString() );
            }
            var buffer = [];
            // Serialize each key in the object.
            for (var name in data) {
                if (!data.hasOwnProperty(name)) {
                    continue;
                }
                var value = data[name];
                buffer.push(
                    encodeURIComponent(name) +
                    "=" +
                    encodeURIComponent(( value == null ) ? "" : value)
                );
            }
            // Serialize the buffer and clean it up for transportation.
            var source = buffer
                    .join("&")
                    .replace(/%20/g, "+")
                ;
            return ( source );
        }
    }
);
// -------------------------------------------------- //
// -------------------------------------------------- //
// I override the "expected" $sanitize service to simply allow the HTML to be
// output for the current demo.
// --
// NOTE: Do not use this version in production!! This is for development only.
app.value(
    "$sanitize",
    function (html) {
        return ( html );
    }
);