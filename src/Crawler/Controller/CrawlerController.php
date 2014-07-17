<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 17/07/14
 * Time: 16:39
 */
namespace Crawler\Controller;

use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\Output;

class CrawlerController
{
    /**
     * @var \PHPCrawler
     */
    private $crawler;

    public function __construct(\PHPCrawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function crawlAction(Input $input, Output $output)
    {

// URL to crawl
        $this->crawler->setURL("http://www.php.net/manual/en/book.mysql.php");

// Only receive content of files with content-type "text/html"
        $this->crawler->addContentTypeReceiveRule("#text/html#");

// Ignore links to pictures, dont even request pictures
        $this->crawler->addURLFilterRule('#^http://www.php.net/manual/en/.*mysql[^a-z]# i');

// Store and send cookie-data like a browser does
        $this->crawler->enableCookieHandling(true);

// Set the traffic-limit to 1 MB (in bytes,
// for testing we dont want to "suck" the whole site)
        $this->crawler->setTrafficLimit(50000 * 1024);

// That's it, start crawling using 5 processes
        $this->crawler->goMultiProcessed(10);

// At the end, after the process is finished, we print a short
// report (see method getProcessReport() for more information)
        $report = $this->crawler->getProcessReport();

        if (PHP_SAPI == "cli") $lb = "\n";
        else $lb = "<br />";

        echo "Summary:".$lb;
        echo "Links followed: ".$report->links_followed.$lb;
        echo "Documents received: ".$report->files_received.$lb;
        echo "Bytes received: ".$report->bytes_received." bytes".$lb;
        echo "Process runtime: ".$report->process_runtime." sec".$lb;
    }
} 