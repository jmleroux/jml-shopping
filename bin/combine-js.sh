#!/bin/bash
myLocation="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )";

srcDirectory=$myLocation/../src/js;
publicDirectory=$myLocation/../public/js;

headerJs=$publicDirectory/main.js;
inlineJs=$publicDirectory/jmlshopping.js;

cd $srcDirectory;

cat angular.min.js              \
    angular-route.js        \
    ui-bootstrap-tpls.min.js    \
> $headerJs;

cat services.js                 \
    controllers.js              \
    shopping.js                 \
> $inlineJs;
