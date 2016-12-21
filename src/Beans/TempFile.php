<?php

namespace Feedr\Beans;
use Feedr\Exceptions\TempFileException;
use Feedr\Interfaces\TempResource;

/**
 * Class TempFile
 * @package Feedr\Beans
 */
class TempFile implements TempResource
{

	const FILENAME_SECTION_SEPARATOR = '-';

	const FILENAME_SUFFIX = '.xml';

	/** @var string */
	private $basePath;

	/** @var string */
	private $fileName;

	/** @var string */
	private $filePrefix;

	/** @var string[] */
	private $fileMeta;

	/**
	 * TempFile constructor.
	 * @param $basePath
	 * @param $filePrefix
	 * @param array $fileMeta
	 */
	public function __construct($basePath, $filePrefix, $fileMeta = [])
	{
		$this->basePath = $basePath;
		$this->filePrefix = $filePrefix;
		$this->fileMeta = $fileMeta;

		$this->createNewTempFile();
	}

	/**
	 * @return string|null
	 */
	public function getResourceUri()
	{
		if (empty($this->fileName)) {
			return NULL;
		}

		return 'file://' . $this->basePath . (substr($this->basePath, -1) === '/' ? '' : '/') . $this->fileName;
	}

	/**
	 * @param $input
	 */
	public function write($input)
	{
		file_put_contents($this->getResourceUri(), $input);
	}

	/**
	 * @return string|null
	 */
	private function getFilePath()
	{
		if (empty($this->fileName)) {
			return NULL;
		}

		return $this->basePath . (substr($this->basePath, -1) === '/' ? '' : '/') . $this->fileName;
	}

	private function createNewTempFile()
	{
		$timestamp = time();

		$fileName = $this->filePrefix;
		if (is_array($this->fileMeta)) {
			foreach ($this->fileMeta as $metaEntry) {
				$fileName .= self::FILENAME_SECTION_SEPARATOR . (string) $metaEntry;
			}
		}
		$fileName .= self::FILENAME_SECTION_SEPARATOR . $timestamp;
		$fileName .= self::FILENAME_SUFFIX;

		$this->fileName = $fileName;

		$fileHandle = fopen($this->getResourceUri(), 'w');
		if ($fileHandle === FALSE) {
			throw new TempFileException("Could not create/open the temp file in path \"{$this->getResourceUri()}\"");
		}
		fclose($fileHandle);
	}

}
