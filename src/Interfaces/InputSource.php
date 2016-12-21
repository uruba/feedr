<?php

namespace Feedr\Interfaces;

use Feedr\Beans\TempFile;

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
	 * @return TempFile
	 */
	public function createTempFile($tempPath)
	{
		// initialize the temp file
		$tempFile = new TempFile($tempPath, self::FILENAME_PREFIX, $this->getTempFileNameMeta());

		// populate the temp file
		$tempFile->write($this->createStream());

		return $tempFile;
	}

}
