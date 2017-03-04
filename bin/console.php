#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/../config/global.php';

$app = new Jmleroux\Console\Application($config);
$app['console']->run();
