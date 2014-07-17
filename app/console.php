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

        # Register crawler
        $crawlers = [];
        for ($i=0;$i<1;$i++) {
            $crawlers[] = new \Crawler\Crawler();
        }

        $task = new \Crawler\Controller\CrawlerController($crawlers);
        $task->crawlAction($input, $output);
    }
);
return $console;
