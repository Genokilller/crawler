<?php

namespace Crawler\Provider;

use Crawler\Controller\CrawlerController;
use Crawler\Crawler;
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
