<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$console = new Application('Search engine', '0.1');
$console->getDefinition()->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev'));
$console->setDispatcher($app['dispatcher']);
$console->register('crawl')
    ->setDefinition(array(
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
    ))
    ->setDescription('Test crawl')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {

        // Inculde the phpcrawl-mainclass
        include_once(__DIR__."/../libs/Crawler/PHPCrawler.class.php");
        include_once(__DIR__."/../libs/Crawler/Enums/PHPCrawlerUrlCacheTypes.class.php");
        include_once(__DIR__."/../libs/Crawler/PHPCrawlerUtils.class.php");

        # Register crawler
        $crawler = new \Crawler\Crawler($app['crawler.repository']);

        $task = $app['crawler.controller'];
        $task->crawlAction($input, $output, $crawler);
    }
);
$console->register('initializeClient')
    ->setDefinition(array(
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
    ))
    ->setDescription('Initialize a new client')
    ->addArgument('client')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $task = $app['crawler.controller'];
        $task->initializeClientAction($input, $output);
    }
);
return $console;
