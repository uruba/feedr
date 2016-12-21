<?php

namespace Feedr\Inputs;

use Feedr\Beans\TempFile;
use Feedr\Interfaces\InputSource;
use GuzzleHttp\Client;

/**
 * Class HttpInput
 * @package Feedr\Inputs
 */
class HttpInput implements InputSource  // TODO - make PSR-7 compatible instead of tying to Guzzle
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

	/** @return TempFile */
	public function createTempFile($tempPath)
	{
		// initialize the temp file
		$urlHost = parse_url($this->httpLink);
		$fileMeta['base_url'] = isset($urlHost['host']) ? str_replace('.', '_', $urlHost['host']) : '';

		$tempFile = new TempFile($tempPath, self::FILENAME_PREFIX, $fileMeta);

		// populate the temp file
		$response = $this->makeRequest($this->httpLink);

		file_put_contents($tempFile->getFilePath(), $response);

		return $tempFile;
	}

	/**
	 * @param $httpLink
	 */
	private function makeRequest($httpLink)
	{
		$resource = $this->guzzleClient->request('GET', $httpLink);
		return $resource->getBody();
	}

}
