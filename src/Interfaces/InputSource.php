<?php

namespace Feedr\Interfaces;

use Feedr\Beans\TempFile;
use Feedr\Beans\TempStream;

/**
 * Class InputSource
 * @package Feedr\Interfaces
 */
abstract class InputSource
{

	const FILENAME_PREFIX = 'temp';

	/**
	 * @return mixed
	 */
	public abstract function createStream();

	/**
	 * @return string[]
	 */
	public abstract function getTempFileNameMeta();

	/**
	 * @param string $tempPath
	 * @return TempResource
	 */
	public function createTempResource($tempPath)
	{
		// initialize the temp file/stream
		if (empty($tempPath)) {
			$tempFile = new TempStream();
		} else {
			$tempFile = new TempFile($tempPath, self::FILENAME_PREFIX, $this->getTempFileNameMeta());
		}

		// populate the temp file
		$tempFile->write($this->createStream());

		return $tempFile;
	}

}
