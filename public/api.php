<?php

use Jmleroux\JmlShopping\Api\MicroKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require __DIR__.'/../Api/app/autoloader.php';

$app = new MicroKernel('prod', false);
$app->loadClassCache();

$request = Request::createFromGlobals();
$response = $app->handle($request);
$response->send();

$app->terminate($request, $response);
