<?php

namespace Feedr\Core;

use Feedr\Beans\Feed;
use Feedr\Beans\Feed\FeedItem;
use Feedr\Beans\FeedReadConfig;
use Feedr\Exceptions\InvalidFeedException;
use Feedr\Factories\XMLReaderFactory;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Validator;
use Psr\Log\LoggerInterface;

/**
 * Class Reader
 * @package Feedr\Core
 */
class Reader
{
    /** @var FeedReadConfig */
    private $feedReadConfig;

    /**
     * Reader constructor.
     * @param FeedReadConfig $feedReadConfig
     */
    public function __construct(FeedReadConfig $feedReadConfig)
    {
        $this->feedReadConfig = $feedReadConfig;
    }

    public function getFeedReadConfig()
    {
        return $this->feedReadConfig;
    }

    public function setFeedReadConfig(FeedReadConfig $feedReadConfig)
    {
        $this->feedReadConfig = $feedReadConfig;
    }

    /**
     * @param InputSource $inputSource
     * @param array $validators
     * @return Feed
     */
    public function read(InputSource $inputSource, $validators = [])
    {
        if (is_array($validators)) {
            foreach ($validators as $validator) {
                if ($validator instanceof Validator) {
                    $validator->validate($inputSource, $this->feedReadConfig->getTempPath());
                }
            }
        }

        $xmlReader = XMLReaderFactory::manufactureXmlReader(
            $inputSource,
            $this->feedReadConfig->getTempPath()
        );

        $mode = $this->feedReadConfig->getSpec();

        $specDocument = $mode->getSpecDocument();
        $specItem = $mode->getSpecItem();

        /** @var LoggerInterface $logger */
        $logger = $this->feedReadConfig->getLogger();

        // A container for the feed
        $feed = new Feed($mode);

        foreach (explode('/', $specDocument->getRoot()) as $pathPart) {
            do {
                $xmlReader->read();
            } while ($xmlReader->nodeType !== \XMLReader::ELEMENT && $xmlReader->nodeType !== 0);

            if ($xmlReader->name != $pathPart) {
                throw new InvalidFeedException(
                    sprintf(
                        "The root path must be '%s'",
                        $specDocument->getRoot()
                    )
                );
            }
        }

        $baseDepthDocument = $xmlReader->depth + 1;

        // Initialize the info about the feed
        while ($xmlReader->read()) {
            if ($xmlReader->nodeType === \XMLReader::ELEMENT && $xmlReader->depth === $baseDepthDocument) {
                if (in_array($xmlReader->name, $specDocument->getAllElems())) {
                    $feed->{$xmlReader->name} = $this->getCurrentElementContent($xmlReader);
                } elseif ($xmlReader->name === $specItem->getRoot()) {
                    break;
                }
            }
        }

        $logger->info('Basic feed info was loaded');

        // Iterate the item nodes
        do {
            if ($xmlReader->nodeType === \XMLReader::ELEMENT &&
                $xmlReader->depth === $baseDepthDocument &&
                $xmlReader->name === $specItem->getRoot()) {
                    $xmlElement = new \SimpleXMLElement($xmlReader->readOuterXML());

                    $feedItem = new FeedItem($mode);

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

        $logger->info('The feed items were loaded');

        $xmlReader->close();

        return $feed;
    }

    /**
     * @param \XMLReader $xmlReader
     * @return null|string
     */
    private function getCurrentElementContent(\XMLReader $xmlReader)
    {
        if ($xmlReader->nodeType === \XMLReader::ELEMENT) {
            $elemDepth = $xmlReader->depth;

            $xmlReader->read();
            $currentVal = $this->convertStringToDateTime(trim($xmlReader->value));


            $subElems = [];
            do {
                $xmlReader->read();
                if ($xmlReader->nodeType === \XMLReader::ELEMENT) {
                    $subElems[$xmlReader->name] = $this->getCurrentElementContent($xmlReader);
                }
            } while (!($xmlReader->nodeType === \XMLReader::END_ELEMENT && $xmlReader->depth === $elemDepth));

            if (!empty($subElems)) {
                $currentVal = $subElems;
            }

            return $currentVal;
        }

        return null;
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
     * @return \DateTime|string
     */
    private function convertStringToDateTime($dateTimeString)
    {
        $convertedDateTimeString = \DateTime::createFromFormat(
            $this->feedReadConfig->getSpec()->getDateTimeFormat(),
            $dateTimeString
        );

        if ($convertedDateTimeString !== false) {
            return $convertedDateTimeString;
        }

        return $dateTimeString;
    }
}
