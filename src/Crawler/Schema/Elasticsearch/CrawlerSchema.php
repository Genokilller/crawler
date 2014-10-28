<?php
/**
 * Created by PhpStorm.
 * User: vincentp
 * Date: 26/10/2014
 * Time: 14:23
 */

namespace Crawler\Schema\Elasticsearch;

use Crawler\Repository\BaseRepository;
use Elastica\Index;

class CrawlerSchema
{
    const GENERAL_CRAWL_DATA_TYPE_NAME = 'general-crawl-data';
    const URLS_CRAWL_DATA_TYPE_NAME = 'urls-crawl-data';

    /**
     * @var BaseRepository
     */
    private $repository;

    function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $clientName
     */
    public function initializeClient($clientName)
    {
        # Create index
        $index = $this->repository->createIndex($clientName);

        # Create types
        $this->createGeneralCrawlDataType($index);
        $this->createUrlsCrawlDataType($index);
    }

    /**
     * @param Index $index
     */
    public function createGeneralCrawlDataType(Index $index)
    {
        $type = $this->repository->getType($index->getName(), self::GENERAL_CRAWL_DATA_TYPE_NAME);

        $parameters = ['_timestamp' => ['enabled' => TRUE]];
        $properties = [
            'crawlId' => ['type' => 'string'],
            'path' => ['type' => 'string'],
            'url' => ['type' => 'string'],
            'host' => ['type' => 'string'],
            'httpCode' => ['type' => 'integer'],
            'metadata' => ['type' => 'object', 'dynamic' => TRUE, 'index' => 'not_analyzed'],
            'contentType' => ['type' => 'string'],
            'protocol' => ['type' => 'string'],
            'query' => ['type' => 'string'],
            'content' => ['type' => 'string'],
            'error' => ['type' => 'nested', 'include_in_parent' => TRUE, 'properties' => [
                'code' => ['type' => 'integer'],
                'occurred' => ['type' => 'string'],
                'message' => ['type' => 'string'],
            ]],
            'header' => ['type' => 'nested', 'include_in_parent' => TRUE, 'properties' => [
                'content' => ['type' => 'string'],
                'occurred' => ['type' => 'string'],
                'send' => ['type' => 'string'],
            ]],
            'referrer' => ['type' => 'nested', 'include_in_parent' => TRUE, 'properties' => [
                'url' => ['type' => 'string'],
                'raw' => ['type' => 'string'],
                'text' => ['type' => 'string'],
                'code' => ['type' => 'string'],
            ]],
            'timing' => ['type' => 'nested', 'include_in_parent' => TRUE, 'properties' => [
                'dataTransferTime' => ['type' => 'float'],
                'dataTransferRate' => ['type' => 'float'],
                'serverResponseTime' => ['type' => 'float'],
                'serverConnectTime' => ['type' => 'float'],
                'bytes' => ['type' => 'float'],
            ]],
        ];

        $this->repository->createType($type, $parameters, $properties);
    }

    public function createUrlsCrawlDataType(Index $index)
    {
        $type = $this->repository->getType($index->getName(), self::URLS_CRAWL_DATA_TYPE_NAME);

        $parameters = ['_timestamp' => ['enabled' => TRUE]];
        $properties = [
            'rebuild' => ['type' => 'string'],
            'raw' => ['type' => 'string'],
            'text' => ['type' => 'string'],
            'code' => ['type' => 'string'],
            'referrer' => ['type' => 'string'],
            'referrerHash' => ['type' => 'string'],
            'isRedirect' => ['type' => 'boolean'],
        ];

        $this->repository->createType($type, $parameters, $properties);
    }
} 