var myApp =angular.module('myApp',["ngRoute"]);
myApp.config(function($routeProvider) {
    $routeProvider

        .when("/", {
            templateUrl: "../views/index.blade.php",
            controller: "indexController"
        })
        // .when("/create",{
        //     templateUrl : "sponsor/create.blade.php",
        //     controller: "createUserController"
        // })
        .otherwise({
            template: "<h1>None</h1><p>Nothing has been selected</p>"
        });

});

/////////
myApp.controller('indexController', function ($scope, $http,$window ) {


    // $scope.files = [];
$scope.uploadFile =[];

    $scope.loadFiles = function () {
        $http.get('/index')
            .then(function success(e) {
                // $scope.files = e.data.files;

            });
    };
    $scope.loadFiles();


//post

    $scope.chooseFile= function () {
        var payload = new FormData();
        var files = document.getElementById('uploadFile').files[0];
        payload.append('uploadFile',files);

        $http({
            method: 'POST',
            url: '/index/export',
            data: payload,
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},
            dataType: 'json',
        }).then(function success(e) {
            console.log(e);
            // $scope.files = e.data;
            // alert('sucessful');

        }, function error(error) {
            // alert('error ');
            $scope.recordErrors(error);

        });

    };

    $scope.recordErrors = function (error) {
        $scope.errors = [];
        if (error.data.errors.uploadFile) {
            $scope.errors.push(error.data.errors.uploadFile[0]);
        }
    };




})
