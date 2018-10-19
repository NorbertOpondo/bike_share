angular.module('notesApp',['ngRoute']).config(['$routeProvider','$locationProvider',function($routeProvider,$locationProvider){
    $locationProvider.html5Mode(true)
    $routeProvider
    .when('dashboard/home',{
        templateUrl:'home.htm'
    })

    .when('/hirebike',{
        templateUrl:'hiribike.htm'
    })
    .when('/feedback',{
        templateUrl:'feedback.htm'
    })
}]);