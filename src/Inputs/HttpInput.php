<?php

namespace Feedr\Inputs;

use Feedr\Beans\TempFile;
use Feedr\Interfaces\InputSource;
use GuzzleHttp\Client;

class HttpInput implements InputSource
{

	/** @var Client */
	private $guzzleClient;

	public function __construct($httpLink)
	{
		$this->guzzleClient = new Client();
	}

	/** @return TempFile */
	public function createTempFile($tempPath)
	{
		// TODO: Implement createTempFile() method.
	}

}
