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
        $globalData = [
            'path' => $PageInfo->path,
            'url' => $PageInfo->url,
            'host' => $PageInfo->host,
            'httpCode' => $PageInfo->http_status_code,
            'metadata' => $PageInfo->meta_attributes,
            'contentType' => $PageInfo->content_type,
            'protocol' => $PageInfo->protocol,
            'query' => $PageInfo->query,
            'error' => [
                'code' => $PageInfo->error_code,
                'occurred' => $PageInfo->error_occured,
                'message' => $PageInfo->error_string,
            ],
            'header' => [
                'content' => $PageInfo->header,
                'bytes' => $PageInfo->header_bytes_received,
                'send' => $PageInfo->header_send,
            ],
            'referrer' => [
                'url' => $PageInfo->referer_url,
                'raw' => $PageInfo->refering_link_raw,
                'code' => $PageInfo->refering_linkcode,
                'text' => $PageInfo->refering_linktext,
            ],
            'timing' => [
                'dataTransferTime' => $PageInfo->data_transfer_time,
                'dataTransferRate' => $PageInfo->data_transfer_rate,
                'serverResponseTime' => $PageInfo->server_response_time,
                'serverConnectTime' => $PageInfo->server_connect_time,
                'bytes' => $PageInfo->bytes_received,
            ],
        ];

        $content = $PageInfo->content;

        $links = $PageInfo->links_found;


        print_r($globalData['url']."\n");
    }
} 