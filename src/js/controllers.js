var shoppingList = angular.module('shoppingListControllers', ['shoppingServices']);

shoppingList.controller('ProductListCtrl', ['$scope', '$http', 'userService', '$filter',
    function ($scope, $http, userService, $filter) {
        $scope.user = userService;
        $scope.categories = [];
        $scope.products = [];
        $scope.product = {
            id: null,
            product: '',
            category: null,
            quantity: 0
        };
        $scope.navbar = {active: 'product-list'};
        $scope.list = function (product) {
            $http.get('api.php/category', {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.categories = data;
            });
            $http.get('api.php/product', {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.products = data;
            });
        };
        $scope.get = function (product) {
            $http.get('api.php/product/' + product.id, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.product = data;
                $scope.product.category = $filter('filter')($scope.categories, {id: $scope.product.category.id}, true)[0];
                $scope.focusInput = true;
            });
        };
        $scope.update = function (product) {
            $http.post('api.php/product', product, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.products = data;
                $scope.product = null;
                $scope.focusInput = true;
            });
        };
        $scope.deleteProduct = function (id, label) {
            if (!confirm('Delete product ' + label + ' ?')) {
                return;
            }
            $http.delete('api.php/product/' + id, {headers: $scope.user.getTokenHeader()}).success(function (data) {
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
        $scope.reset = function () {
            $scope.product = angular.copy({});
            $scope.focusInput = true;
        };
        $scope.$watch(
            function () {
                return userService.token;
            },
            function () {
                $scope.list();
            }
        );
    }
]);

shoppingList.controller('CategoryListCtrl', ['$scope', '$http', 'userService',
    function ($scope, $http, userService) {
        $scope.user = userService;
        $scope.navbar.active = 'category-list';
        $http.get('api.php/category', {headers: $scope.user.getTokenHeader()}).success(function (data) {
            $scope.categories = data;
        });
        $scope.get = function (category) {
            $http.get('api.php/category/' + category.id, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.category = data;
            });
        };
        $scope.update = function (category) {
            $http.post('api.php/category', category, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.categories = data;
                $scope.category = null;
            });
        };
        $scope.delete = function (categoryId) {
            $http.delete('api.php/category/' + categoryId, {headers: $scope.user.getTokenHeader()}).success(function (data) {
                $scope.categories = data;
            });
        };
    }
]);

shoppingList.controller('MainCtrl', ['$scope', '$location',
    function ($scope, $location) {
        $scope.baseUrl = $location.absUrl();
        $scope.navbar = {
            active: null
        };
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
            $http.post('api.php/login', post)
                .success(function (data) {
                    if (data.token) {
                        $scope.isCollapsed = true;
                    }
                    userService.username = data.username;
                    userService.token = data.token;
                    $scope.mymessage = "";
                })
                .error(function () {
                    $scope.mymessage = "Invalid login";
                });
        };
        $scope.logout = function () {
            $scope.isCollapsed = true;
            userService.username = '';
            userService.token = '';
            sessionStorage.clear();
        };
        $scope.$watch(function () {
            return userService.token;
        }, function () {
            sessionStorage.setItem('user', JSON.stringify(userService));
        });
    }
]);

shoppingList.controller('FooterCtrl', ['$scope',
    function ($scope) {
        $scope.getDatetime = new Date;
    }
]);
