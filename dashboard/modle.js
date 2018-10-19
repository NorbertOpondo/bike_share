angular.module('notesApp',['ngRoute']).config(['$routeProvider','$locationProvider',function($routeProvider,$locationProvider){
    $locationProvider.html5Mode(true)
    $routeProvider.when('/home',{
        templateUrl:'home.htm'
    })
}]);