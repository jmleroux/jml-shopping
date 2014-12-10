#!/bin/bash
myLocation="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )";

targetFile=$myLocation/../../public/js/jmlshopping.js;

cd $myLocation;

cat angular.min.js              \
    angular-route.min.js        \
    ui-bootstrap-tpls.min.js    \
    services.js                 \
    controllers.js              \
    shopping.js                 \
> $targetFile;
