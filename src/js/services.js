var services = angular.module('shoppingServices', []);

services.factory('userService', function () {
    var userService = {
        username: '',
        token: ''
    };

    userService.getTokenHeader = function() {
        return {'X-token': userService.token};
    };
    return userService;
});
