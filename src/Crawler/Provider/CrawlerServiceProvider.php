<?php

namespace Crawler\Provider;

use Crawler\Controller\CrawlerController;
use Silex\Application;
use Silex\ServiceProviderInterface;

class CrawlerServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Silex\Application $app
     */
    public function register(Application $app)
    {

// Inculde the phpcrawl-mainclass
        include_once(__DIR__."/../../../libs/Crawler/PHPCrawler.class.php");

        # Register controller
        $app['crawler.controller'] = $app->share(function() use ($app) {
            return new CrawlerController($app['request']);
        });

        # Register crawler
        $app['crawler'] = $app->share(function() use ($app) {
           return new \PHPCrawler();
        });
    }

    /**
     * {@inheritDoc}
     *
     * @param \Silex\Application $app
     */
    public function boot(Application $app)
    {
    }
}
