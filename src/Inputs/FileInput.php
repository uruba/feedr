<?php

namespace Feedr\Inputs;

use Feedr\Beans\TempFile;
use Feedr\Interfaces\InputSource;

/**
 * Class FileInput
 * @package Feedr\Inputs
 */
class FileInput implements InputSource
{

	const FILENAME_PREFIX = 'file';

	/** @var string */
	private $sourceFilePath;

	/**
	 * FileInput constructor.
	 * @param $sourceFilePath
	 */
	public function __construct($sourceFilePath)
	{
		$this->sourceFilePath = $sourceFilePath;
	}

	/**
	 * @param string $tempPath
	 * @return \Feedr\Beans\TempFile
	 */
	public function createTempFile($tempPath)
	{
		$baseName = explode('.', basename($tempPath));
		$fileMeta['file_name'] = $baseName[0];

		$tempFile = new TempFile($tempPath, self::FILENAME_PREFIX, $fileMeta);

		copy($this->sourceFilePath, $tempFile->getFilePath());

		return $tempFile;
	}

	/** @return string */
	public function getTempFileNamePrefix()
	{
		return self::FILENAME_PREFIX;
	}

}
