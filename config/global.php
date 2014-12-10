<?php
return array(
    'app' => array(
        'app.root' => realpath(dirname(__DIR__ )),
        'debug' => false,
    ),
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../data/shopping.sqlite3',
    ),
);
