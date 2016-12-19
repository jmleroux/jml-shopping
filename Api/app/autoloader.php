<?php

error_reporting(error_reporting() & ~E_USER_DEPRECATED);

$loader = require __DIR__.'/../vendor/autoload.php';

return $loader;
