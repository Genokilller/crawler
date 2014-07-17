<?php

use Silex\Application;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__."/../config/".$app['env'].".yml"));

$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());

$app->register(new SilexPhpRedis\PhpRedisProvider(), array(
    'redis.host' => $app['config']['redis']['host'],
    'redis.port' => $app['config']['redis']['port'],
    'redis.timeout' => $app['config']['redis']['timeout'],
    'redis.persistent' => $app['config']['redis']['persistent']
));

# Register analytics services
$app->register(new \Crawler\Provider\CrawlerServiceProvider());

require __DIR__ . '/routing.php';
require __DIR__ . '/security.php';
require __DIR__ . '/databases.php';

return $app;
