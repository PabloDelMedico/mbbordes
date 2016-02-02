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
            if (data.success === true) {
                $scope.submitAnswer = 'Su mensaje ha sido enviado. Gracias.';
                $scope.alertClass = 'alert alert-success';
                $scope.formData = {};
            } else {
                $scope.submitAnswer = "Sorry " + $scope.formData.name + ", it seems that my mail server is not responding. Please try again later!";
                $scope.submitAnswer += data.message;
                $scope.alertClass = 'alert alert-danger';
            }
        }).error(function(data, status, headers, config) {
            $scope.submitAnswer = "Sorry " + $scope.formData.name + ", it seems that my mail server is not responding. Please try again later!";
            $scope.submitAnswer += data.message;
            $scope.alertClass = 'alert alert-danger';
        });

        $scope.hideAnswer = false;

    };
}]);
