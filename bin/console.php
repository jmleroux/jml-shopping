#!/usr/bin/env php
<?php

set_time_limit(90);

require_once __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/../config/global.php';

use Jmleroux\Console\Command;

$app = new Jmleroux\Console\Application($config);
$app['console']->run();
