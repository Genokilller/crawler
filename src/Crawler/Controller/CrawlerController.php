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
    private $crawlers;

    public function __construct(array $crawlers)
    {
        $this->crawlers = $crawlers;
    }

    public function crawlAction(Input $input, Output $output)
    {
        foreach ($this->crawlers as $crawler) {
            $this->launchCrawler($crawler);
        }
    }

    private function launchCrawler(\PHPCrawler $crawler)
    {
        $crawler->setUrlCacheType(\PHPCrawlerUrlCacheTypes::URLCACHE_MEMORY);
        $crawler->setWorkingDirectory("/dev/shm/");

        // URL to crawl
        $crawler->setURL("http://www.alittlemarket.com");

        // Only receive content of files with content-type "text/html"
        $crawler->addLinkSearchContentType("#text/xml# i");

        // Ignore links to pictures, dont even request pictures
        $crawler->addURLFilterRule('#^http://www.alittlemarket.com.* i');

        // Store and send cookie-data like a browser does
        $crawler->enableCookieHandling(false);

        $crawler->enableAggressiveLinkSearch(false);
        $crawler->setLinkExtractionTags(array("href"));

        // Set the traffic-limit to 1 MB (in bytes,
        // for testing we dont want to "suck" the whole site)
        $crawler->setTrafficLimit(100000 * 1024);

        // Limit to 100k per page
        $crawler->setContentSizeLimit(120 * 1024);

        // That's it, start crawling using 5 processes
        $crawler->goMultiProcessed(10, \PHPCrawlerMultiProcessModes::MPMODE_CHILDS_EXECUTES_USERCODE);

        // At the end, after the process is finished, we print a short
        // report (see method getProcessReport() for more information)
        $report = $crawler->getProcessReport();

        $lb = "\n";
        echo "Summary:".$lb;
        echo "Links followed: ".$report->links_followed.$lb;
        echo "Documents received: ".$report->files_received.$lb;
        echo "Bytes received: ".$report->bytes_received." bytes".$lb;
        echo "Process runtime: ".$report->process_runtime." sec".$lb;
    }
} 