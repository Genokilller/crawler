<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 17/07/14
 * Time: 20:46
 */

namespace Crawler;


class Crawler extends \PHPCrawler
{
    public function handleDocumentInfo(\PHPCrawlerDocumentInfo $PageInfo)
    {

        print_r($PageInfo->toArray());die;
    }
} 