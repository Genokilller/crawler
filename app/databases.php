<?php

$databases = array();

if (empty($app['config']['databases'])) {
    throw new \Exception('You must configure at least one database');
}

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => $app['config']['databases'],
));
