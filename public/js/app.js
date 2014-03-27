// setter
var app = angular.module("app", ['ngRoute']).config(function($routeProvider) {

    $routeProvider.when('/signup', {
      templateUrl: 'views/signup.html',
      controller: 'SignupController'
    });

    $routeProvider.when('/login', {
      templateUrl: 'views/login.html',
      controller: 'LoginController'
    });

    // $routeProvider.when('/logout', {
    //   templateUrl: 'logout.php',
    //   controller: 'LogoutController'
    // });

    $routeProvider.when('/dashboard', {
      templateUrl: 'dashboard.php',
      controller: 'DashboardController'
    });

    $routeProvider.when('/addexpense', {
      templateUrl: 'addexpense.php',
      controller: 'AddExpenseController'
    });


    $routeProvider.otherwise({ redirectTo : '/signup' });
});

app.factory("AuthenticationService", function($location) {
  return {
      signin: function() {
        $location.path('/login');
      },

      signup: function() {
        $location.path('/signup');
      },

      logout: function() {
        $location.path('/logout');
      }
  };
});


app.controller('SignupController', function($scope, AuthenticationService) {
  // $scope.signup = function() {
  //   AuthenticationService.signup();
  // };
    $scope.signin = function() {
    AuthenticationService.signin();
  };
});

app.controller('LoginController', function($scope, AuthenticationService) {
  // $scope.credentials = { username: "", password: "" };
});

app.controller('LogoutController', function($scope, AuthenticationService) {
  // $scope.credentials = { username: "", password: "" };
  // $scope.logout = function() {
  //   AuthenticationService.logout();
  // };
});

app.controller('DashboardController', function() {

});

app.controller('AddExpenseController', function() {

});
