<?php

namespace Feedr\Core;

use Feedr\Beans\Feed;
use Feedr\Beans\Feed\FeedItem;
use Feedr\Beans\TempFile;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Spec;
use Feedr\Interfaces\TempResource;
use Psr\Log\LoggerInterface;

/**
 * Class Reader
 * @package Feedr\Core
 */
class Reader
{

	/** @var \XMLReader */
	private $xmlReader;

	/** @var Spec */
	private $mode;

	/** @var LoggerInterface */
	private $logger;

	/**
	 * Reader constructor.
	 * @param Spec $mode
	 */
	public function __construct(Spec $mode, LoggerInterface $logger)
	{
		$this->xmlReader = new \XMLReader();
		$this->switchMode($mode);
		$this->logger = $logger;
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
	 * @return Feed
	 */
	public function read(InputSource $inputSource, $tempPath)
	{
		/** @var TempResource $tempResource */
		$tempResource = $inputSource->createTempResource($tempPath);

		// A container for the feed
		$feed = new Feed($this->mode);

		$xmlReader = $this->xmlReader;

		$specDocument = $this->mode->getSpecDocument();
		$specItem = $this->mode->getSpecItem();

		$xmlReader->open($tempResource->getResourceUri());

		foreach (explode('/', $specDocument->getRoot()) as $pathPart) {
			do {
				$xmlReader->read();
			} while ($xmlReader->nodeType !== \XMLReader::ELEMENT && $xmlReader->nodeType !== 0);

			if ($xmlReader->name != $pathPart) {
				throw new \Feedr\Exceptions\InvalidFeedException(
					sprintf(
						"The root path must be '%s'",
						$specDocument->getRoot()
					)
				);
			}
		}

		// Initialize the info about the feed
		while ($xmlReader->read()) {
			if ($xmlReader->nodeType === \XMLReader::ELEMENT) {
				if (in_array($xmlReader->name, $specDocument->getAllElems())) {
					$feed->{$xmlReader->name} = $this->getCurrentElementContent();
				} else if ($xmlReader->name === $specItem->getRoot()) {
					break;
				}
			}
		}

		$this->logger->info('Basic feed info was loaded');

		// Iterate the item nodes
		do {
			if ($xmlReader->nodeType === \XMLReader::ELEMENT &&
				$xmlReader->name === $specItem->getRoot()) {
					$xmlElement = new \SimpleXMLElement($xmlReader->readOuterXML());

					$feedItem = new FeedItem($this->mode);

					foreach ($specItem->getAllElems() as $elem) {
						$subNodeVal = $this->getSubNodeValue($xmlElement, $elem);

						if (!empty($subNodeVal)) {
							$feedItem->{$elem} = $subNodeVal;
						}
					}

					// Add the item to the item array in the feed object
					$feed->addItem($feedItem);
			}
		} while ($xmlReader->next());

		$this->logger->info('The feed items were loaded');

		$xmlReader->close();

		return $feed;
	}

	/**
	 * @return LoggerInterface
	 */
	public function getLogger()
	{
		return $this->logger;
	}

	/**
	 * @param LoggerInterface $logger
	 */
	public function setLogger($logger)
	{
		$this->logger = $logger;
	}

	/**
	 * @return null|string
	 */
	private function getCurrentElementContent()
	{
		if ($this->xmlReader->nodeType === \XMLReader::ELEMENT) {
			$this->xmlReader->read();
			return $this->convertStringToDateTime(trim($this->xmlReader->value));
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
		return $this->convertStringToDateTime(trim((string) $element->{$fieldName}));
	}

	/**
	 * @param string $dateTimeString
	 * @return string|\DateTime
	 */
	private function convertStringToDateTime($dateTimeString)
	{
		$convertedDateTimeString = \DateTime::createFromFormat($this->mode->getDateTimeFormat(), $dateTimeString);

		if ($convertedDateTimeString !== FALSE) {
			return $convertedDateTimeString;
		}

		return $dateTimeString;
	}

}
