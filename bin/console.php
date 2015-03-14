#!/usr/bin/env php
<?php

set_time_limit(90);

require_once __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/../config/global.php';

use Console\Command;

$app = new Console\Application($config);
$app['console']->run();
