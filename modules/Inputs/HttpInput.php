<?php

namespace Feedr\Inputs;

use Feedr\Core\Input\InputSource;
use GuzzleHttp\Client;

/**
 * Class HttpInput
 * @package Feedr\Inputs
 */
class HttpInput extends InputSource
{
    const FILENAME_PREFIX = 'http';

    /** @var Client */
    private $guzzleClient;

    /** @var string */
    private $httpLink;

    /**
     * HttpInput constructor.
     * @param $httpLink
     */
    public function __construct($httpLink)
    {
        $this->httpLink = $httpLink;

        $this->guzzleClient = new Client();
    }

    /**
     * @return mixed
     */
    public function createStream()
    {
        return $this->makeRequest($this->httpLink);
    }

    /**
     * @return string[]
     */
    public function getTempFileNameMeta()
    {
        $urlHost = parse_url($this->httpLink);
        $fileMeta['base_url'] = isset($urlHost['host']) ? str_replace('.', '_', $urlHost['host']) : '';

        return $fileMeta;
    }

    /**
     * @param $httpLink
     * @return \Psr\Http\Message\StreamInterface
     */
    private function makeRequest($httpLink)
    {
        $resource = $this->guzzleClient->request('GET', $httpLink);
        return $resource->getBody();
    }
}
