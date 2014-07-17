<?php

use Symfony\Component\Debug\Debug;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");

require_once __DIR__.'/../vendor/autoload.php';

//Debug::enable();

$app = $app = new \Silex\Application();
$app['env'] = 'dev';

$app = require __DIR__ . '/../app/app.php';

// enable the debug mode
$app['debug'] = true;

$app->run();
