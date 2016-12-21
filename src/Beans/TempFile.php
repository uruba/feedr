<?php

namespace Feedr\Beans;

/**
 * Class TempFile
 * @package Feedr\Beans
 */
class TempFile
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

	/** @var bool */
	private $isDeleted;

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
		$this->isDeleted = FALSE;
	}

	/**
	 * @return string
	 */
	public function getBasePath()
	{
		return $this->basePath;
	}

	/**
	 * @return string|null
	 */
	public function getFilePath()
	{
		if (empty($this->fileName)) {
			return NULL;
		}

		return $this->basePath . (substr($this->basePath, -1) === '/' ? '' : '/') . $this->fileName;
	}

	/**
	 * @return string
	 */
	public function getFilePrefix()
	{
		return $this->filePrefix;
	}

	/**
	 * @return array
	 */
	public function getFileMeta()
	{
		return $this->fileMeta;
	}

	public function delete()
	{
		unlink($this->getFilePath());
		$this->isDeleted = TRUE;
	}

	/**
	 * @return bool
	 */
	public function isDeleted()
	{
		return $this->isDeleted;
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

		fclose(fopen($this->getFilePath(), 'w'));
	}

}
