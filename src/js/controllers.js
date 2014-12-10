var shoppingList = angular.module('shoppingListControllers', ['shoppingServices']);

shoppingList.controller('ProductListCtrl', ['$scope', '$http', 'userService', '$filter',
    function ($scope, $http, userService, $filter) {
        $scope.user = userService;
        $scope.categoryList = [];
        $scope.product = {
            product : '',
            category: null,
            quantity : 0
        };
        $scope.list = function (product) {
            $http.get('api.php/category', {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.categoryList = data;
            });
            $http.get('api.php/product', {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.products = data;
            });
        };
        $scope.get = function (product) {
            $http.get('api.php/product/' + product.id, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.product = data;
                $scope.product.category = $filter('filter')($scope.categoryList, {id: $scope.product.category.id})[0];
                $scope.focusInput = true;
            });
        };
        $scope.update = function (product) {
            $http.post('api.php/product', product, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.products = data;
                $scope.product = null;
            });
        };
        $scope.deleteProduct = function (productId) {
            if (!confirm('Delete product ?')) {
                return;
            }
            $http.delete('api.php/product/' + productId, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.products = data;
            });
        };
        $scope.removeAllProducts = function () {
            if (!confirm('Delete all ?')) {
                return;
            }
            $http.delete('api.php/product', {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.products = data;
            });
        };
        $scope.$watch(
            function() { return userService.token; },
            function (newVal) {$scope.list();}
        );
    }
]);

shoppingList.controller('CategoryListCtrl', ['$scope', '$http', 'userService',
    function ($scope, $http, userService) {
        $scope.user = userService;
        var master = {
            label: ''
        };
        $http.get('api.php/category', {headers: $scope.user.getTokenHeader()}).success(function (data) {
            $scope.categoryList = data;
        });
        $scope.get = function (category) {
            $http.get('api.php/category/' + category.id, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.category = data;
            });
        };
        $scope.update = function (category) {
            $http.post('api.php/category', category, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.categoryList = data;
                $scope.category = null;
            });
        };
        $scope.delete = function (categoryId) {
            $http.delete('api.php/category/' + categoryId, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.categoryList = data;
            });
        };
    }
]);

shoppingList.controller('MainCtrl', ['$scope', '$location',
    function ($scope, $location) {
        $scope.baseUrl = $location.absUrl();
    }
]);

shoppingList.controller('NavbarCtrl', ['$scope', '$http', 'userService',
    function ($scope, $http, userService) {
        $scope.user = userService;
        if (sessionStorage.getItem('user')) {
            var localUser = JSON.parse(sessionStorage.getItem('user'));
            userService.username = localUser.username;
            userService.token = localUser.token;
        }
        $scope.login = function (post) {
            $http.post('api.php/login', post).success(function (data) {
                if (data.token) {
                    $scope.isCollapsed = true;
                }
                userService.username = data.username;
                userService.token = data.token;
            });
        };
        $scope.logout = function() {
            $scope.isCollapsed = true;
            userService.username = '';
            userService.token = '';
            sessionStorage.clear();
        };
        $scope.$watch(function() { return userService.token; }, function (newVal) {
            sessionStorage.setItem('user', JSON.stringify(userService));
        });
    }
]);

shoppingList.controller('FooterCtrl', ['$scope',
    function ($scope) {
        $scope.getDatetime = new Date;
    }
]);
