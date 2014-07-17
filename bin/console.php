#!/usr/bin/env php
<?php

require_once __DIR__.'/../vendor/autoload.php';

set_time_limit(0);

use Symfony\Component\Console\Input\ArgvInput;

$input = new ArgvInput();
$env = $input->getParameterOption(array('--env', '-e'), getenv('SYMFONY_ENV') ?: 'dev');


$app = new Silex\Application();

# Prod mode
$app['env'] = 'dev';

require __DIR__.'/../app/app.php';
$console = require __DIR__.'/../app/console.php';
$console->run();