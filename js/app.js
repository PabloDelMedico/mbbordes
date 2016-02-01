var app = angular.module('bordesApp', []);

app.controller('ContactCtrl', ['$scope', '$http', function($scope, $http) {

    $scope.submitAnswer = '';
    $scope.hideAnswer = true;
    $scope.alertClass = '';

    // create a blank object to hold our form information
    // $scope will allow this to pass between controller and view
    /*    $scope.formData = {};*/

    $scope.submitForm = function() {
        $http({
            url: "././mail/contact.php",
            method: "POST",
            data: $scope.formData
        }).success(function(data, status, headers, config) {
            if (data.success===true) {
                $scope.submitAnswer = data;
                $scope.alertClass = 'alert alert-success';
                $scope.formData = {};
            }else {
                $scope.submitAnswer = data;
                $scope.alertClass = 'alert alert-danger';
            }
        }).error(function(data, status, headers, config) {
            $scope.submitAnswer = data;
            $scope.alertClass = 'alert alert-danger';
        });

        $scope.hideAnswer = false;

    };
}]);
