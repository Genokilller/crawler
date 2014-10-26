<?php

namespace Crawler\Provider;

use Crawler\Controller\CrawlerController;
use Crawler\Repository\BaseRepository;
use Crawler\Schema\Elasticsearch\CrawlerSchema;
use Elastica\Client;
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
        $app['crawler.client'] = $app->share(function () use ($app) {
            return new Client($app['config']['elasticsearch']);
        });

        $app['crawler.repository'] = $app->share(function () use ($app) {
            return new BaseRepository($app['crawler.client']);
        });

        $app['crawler.schema'] = $app->share(function () use ($app) {
            return new CrawlerSchema($app['crawler.repository']);
        });

        $app['crawler.controller'] = $app->share(function () use ($app) {
            return new CrawlerController($app['crawler.schema']);
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
