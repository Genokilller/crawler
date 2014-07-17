<?php

require_once __DIR__.'/../vendor/autoload.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, content-type");

$app = new \Silex\Application();
$app['env'] = 'prod';

$app = require __DIR__ . '/../app/app.php';

# App run
$app->run();
