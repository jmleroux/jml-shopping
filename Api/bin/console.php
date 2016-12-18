#!/usr/bin/env php
<?php

use Jmleroux\JmlShopping\Api\MicroKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;

set_time_limit(90);

require_once __DIR__ . '/../vendor/autoload.php';

$input = new ArgvInput();
$env = $input->getParameterOption(array('--env', '-e'), getenv('SYMFONY_ENV') ?: 'dev');
$behat = strpos($env, 'behat');
$debug = getenv('SYMFONY_DEBUG') !== '0' && !$input->hasParameterOption(array('--no-debug', ''))
    && $env !== 'prod' && false === $behat;

if ($debug) {
    Debug::enable();
}

$kernel = new MicroKernel($env, $debug);
$application = new Application($kernel);
$application->run($input);
