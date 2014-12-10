var shoppingApp = angular.module('shoppingApp', [
    'ngRoute',
    'ui.bootstrap',
    'shoppingListControllers'
]);

shoppingApp.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
            when('/product-list', {
                templateUrl: 'views/product-list.html',
                controller: 'ProductListCtrl'
            }).
            when('/category-list', {
                templateUrl: 'views/category-list.html',
                controller: 'CategoryListCtrl'
            }).
            when('/logout', {
                controller: 'logoutCtrl'
            }).
            otherwise({
                redirectTo: '/product-list'
            });
    }]);

shoppingApp.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});

shoppingApp.directive('focusMe', function ($timeout) {
    return {
        link: function (scope, element, attrs) {
            scope.$watch(attrs.focusMe, function (value) {
                if (value === true) {
                    $timeout(function () {
                        element[0].focus();
                        scope[attrs.focusMe] = false;
                    });
                }
            });
        }
    };
});
