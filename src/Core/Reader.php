<?php

namespace Feedr\Core;

use Feedr\Beans\Feed\Feed;
use Feedr\Beans\Feed\FeedItem;
use Feedr\Beans\TempFile;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Specs\Spec;

class Reader
{

	/** @var \XMLReader */
	private $xmlReader;

	/** @var Spec */
	private $mode;

	/**
	 * Reader constructor.
	 * @param Spec $mode
	 */
	public function __construct(Spec $mode)
	{
		$this->xmlReader = new \XMLReader();
		$this->switchMode($mode);
	}

	/**
	 * @param Spec $mode
	 */
	public function switchMode(Spec $mode)
	{
		$this->mode = $mode;
	}

	/**
	 * @param InputSource $inputSource
	 * @param string $tempPath
	 * @param boolean $deleteTempFile
	 */
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
				switch ($this->xmlReader->name) {
					// Feed title
					case $this->mode->getSpecDocument()->getPathTitle():
						$feed->setTitle($this->getCurrentElementContent());
						break;
					// Feed link
					case $this->mode->getSpecDocument()->getPathLink():
						$feed->setLink($this->getCurrentElementContent());
						break;
					// Feed created at
					case $this->mode->getSpecDocument()->getPathCreated():
						$feed->setCreatedAt($this->convertStringToDateTime(
							$this->getCurrentElementContent()
						));
						break;
					// Feed updated at
					case $this->mode->getSpecDocument()->getPathUpdated():
						$feed->setUpdatedAt($this->convertStringToDateTime(
							$this->getCurrentElementContent()
						));
						break;
					// Items' parent element (no more main feed info past this point)
					case $this->mode->getSpecItem()->getRoot():
						break 2;
				}
			}
		}

		// TODO - maybe some logging?

		// Iterate the item nodes
		do {
			if ($this->xmlReader->nodeType === \XMLReader::ELEMENT &&
				$this->xmlReader->name === $this->mode->getSpecItem()->getRoot()) {
					$xmlElement = new \SimpleXMLElement($this->xmlReader->readOuterXML());

					$feedItem = new FeedItem();

					// Item title
					$feedItem->setTitle(
						$this->getSubNodeValue($xmlElement, $this->mode->getSpecItem()->getPathTitle())
					);
					// Item link
					$feedItem->setLink(
						$this->getSubNodeValue($xmlElement, $this->mode->getSpecItem()->getPathLink())
					);
					// Item summary
					$feedItem->setSummary(
						$this->getSubNodeValue($xmlElement, $this->mode->getSpecItem()->getPathSummary())
					);
					// Item content
					$feedItem->setContent(
						$this->getSubNodeValue($xmlElement, $this->mode->getSpecItem()->getPathContent())
					);
					// Item author
					$feedItem->setAuthor(
						$this->getSubNodeValue($xmlElement, $this->mode->getSpecItem()->getPathAuthor())
					);

					// Add the item to the item array in the feed object
					$feed->addItem($feedItem);
			}
		} while ($this->xmlReader->next());

		$this->xmlReader->close();

		// Delete the temp file if needed
		if ($deleteTempFile) {
			$tempFile->delete();
		}
	}

	/**
	 * @return null|string
	 */
	private function getCurrentElementContent()
	{
		if ($this->xmlReader->nodeType === \XMLReader::ELEMENT) {
			$this->xmlReader->read();
			return trim($this->xmlReader->value);
		}

		return NULL;
	}

	/**
	 * @param \SimpleXMLElement $element
	 * @param string $fieldName
	 * @return string
	 */
	private function getSubNodeValue(\SimpleXMLElement $element, $fieldName)
	{
		return (string) $element->{$fieldName};
	}

	/**
	 * @param string $dateTimeString
	 * @return bool|\DateTime
	 */
	private function convertStringToDateTime($dateTimeString)
	{
		return \DateTime::createFromFormat($this->mode->getDateTimeFormat(), $dateTimeString);
	}

}
