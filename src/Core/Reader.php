<?php

namespace Feedr\Core;

use Feedr\Beans\Feed\Feed;
use Feedr\Beans\TempFile;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Specs\Spec;

class Reader
{

	/** @var \XMLReader */
	private $xmlReader;

	/** @var Spec */
	private $mode;

	public function __construct(Spec $mode)
	{
		$this->xmlReader = new \XMLReader();
		$this->switchMode($mode);
	}

	public function switchMode(Spec $mode)
	{
		$this->mode = $mode;
	}

	public function read(InputSource $inputSource, $tempPath, $deleteTempFile = TRUE)
	{
		/** @var TempFile $tempFile */
		$tempFile = $inputSource->createTempFile($tempPath);

		// A container for the feed
		$feed = new Feed();

		$this->xmlReader->open($tempFile->getFilePath());

		foreach (explode('/', $this->mode->getSpecDocument()->getRoot()) as $pathPart) {
			do {
				$this->xmlReader->read();
			} while ($this->xmlReader->nodeType !== \XMLReader::ELEMENT);

			if ($this->xmlReader->name != $pathPart) {
				throw new \Feedr\Exceptions\InvalidFeedException(
					sprintf(
						"The root path must be '%s'",
						$this->mode->getSpecDocument()->getRoot()
					)
				);
			}
		}

		// Initialize the info about the feed
		while ($this->xmlReader->read()) {
			if ($this->xmlReader->nodeType === \XMLReader::ELEMENT) {
				$elementName = $this->xmlReader->name;
				$elementContent = $this->getCurrentElementContent();

				switch ($elementName) {
					// Feed title
					case $this->mode->getSpecDocument()->getPathTitle():
						$feed->setTitle($elementContent);
						break;
					// Feed link
					case $this->mode->getSpecDocument()->getPathLink():
						$feed->setLink($elementContent);
						break;
					// Feed created at
					case $this->mode->getSpecDocument()->getPathCreated():
						$feed->setCreatedAt($this->convertStringToDateTime(
							$elementContent
						));
						break;
					// Feed updated at
					case $this->mode->getSpecDocument()->getPathUpdated():
						$feed->setUpdatedAt($this->convertStringToDateTime(
							$elementContent
						));
						break;
					case $this->mode->getSpecItem()->getPathRoot():
						break 2;
				}
			}
		}

		$this->xmlReader->close();

		if ($deleteTempFile) {
			$tempFile->delete();
		}
	}

	private function getCurrentElementContent()
	{
		if ($this->xmlReader->nodeType === \XMLReader::ELEMENT) {
			$this->xmlReader->read();
			return trim($this->xmlReader->value);
		}

		return NULL;
	}

	private function convertStringToDateTime($dateTimeString)
	{
		return \DateTime::createFromFormat($this->mode->getDateTimeFormat(), $dateTimeString);
	}

}
