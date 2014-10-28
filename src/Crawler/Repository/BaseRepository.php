<?php

namespace Crawler\Repository;

use Elastica\Type;
use Elastica\Client;
use Elastica\Index;

/**
 * Class AnalyticsRepository
 * @package Incubart\Repository
 */
class BaseRepository
{
    /**
     * @var Client
     */
    private $client;

    function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param \Elastica\Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return \Elastica\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $indexName
     * @return \Elastica\Index
     */
    public function getIndex($indexName)
    {
        # Get index
        $index = $this->client->getIndex($indexName);

        return $index;
    }

    /**
     * @param $indexName
     * @param $typeName
     * @return Type
     */
    public function getType($indexName, $typeName)
    {
        $index = $this->getIndex($indexName);
        $type = $index->getType($typeName);

        return $type;
    }

    /**
     * @param string $indexName
     * @param string $typeName
     * @param $id
     * @return \Elastica\Document
     */
    public function get($indexName, $typeName, $id)
    {
        # Get index
        $index = $this->client->getIndex($indexName);

        # Get type
        $type = $index->getType($typeName);

        $document = $type->getDocument($id);

        return $document;
    }

    /**
     * Create an index
     *
     * @param string $indexName
     * @param int $shards
     * @param int $replicas
     * @param array $analyzer
     * @param array $tokenizer
     * @param array $filter
     * @param integer $refreshInterval
     * @internal param int $diff
     *
     * @return Index
     */
    public function createIndex($indexName, $shards = 10, $replicas = 1, $analyzer = [], $tokenizer = [], $filter = [], $refreshInterval = 30)
    {
        # Get index
        $index = $this->client->getIndex($indexName);

        $index->create(
            [
                'number_of_shards' => $shards,
                'number_of_replicas' => $replicas,
                'analysis' => [
                    'analyzer' => $analyzer,
                    'tokenizer' => $tokenizer,
                    'filter' => $filter
                ],
                'refresh_interval' => $refreshInterval,
            ]
        );

        return $index;
    }

    /**
     * Create a type
     *
     * @param Type $type
     * @param array $parameters
     * @param array $properties
     * @param string $parent
     * @internal param $indexName
     * @internal param $typeName
     */
    public function createType($type, $parameters = [], $properties = [], $parent = null)
    {
        # Define mapping
        $mapping = new Type\Mapping();
        $mapping->setType($type);

        # Set parameters
        foreach ($parameters as $key => $value) {
            $mapping->setParam($key, $value);
        }

        # Set mapping
        $mapping->setProperties($properties);

        # Set parent
        if (!is_null($parent)) {
            $mapping->setParent($parent);
        }

        # Send mapping to type
        $mapping->send();
    }

    /**
     * Add a document
     *
     * @param $indexName
     * @param $typeName
     * @param array $data
     * @param bool $refresh
     */
    public function addDocument($indexName, $typeName, $data = [], $refresh = true)
    {
        # Get index
        $index = $this->client->getIndex($indexName);

        # Get type
        $type = $index->getType($typeName);

        # Add document to type
        try {
            $type->addDocument($data);
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        # Refresh Index
        if ($refresh) {
            $index->refresh();
        }
    }

    /**
     * Add a list of documents
     *
     * @param $indexName
     * @param $typeName
     * @param array $data
     * @param bool $refresh
     */
    public function addDocuments($indexName, $typeName, $data = [], $refresh = true)
    {
        # Get index
        $index = $this->client->getIndex($indexName);

        # Get type
        $type = $index->getType($typeName);

        # Add documents to type
        try {
            $type->addDocuments($data);
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        # Refresh Index
        if ($refresh) {
            $index->refresh();
        }
    }

}