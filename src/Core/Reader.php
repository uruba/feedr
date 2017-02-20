<?php

namespace Feedr\Core;

use Feedr\Beans\Feed;
use Feedr\Beans\Feed\FeedItem;
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
     * @param bool $validate
     * @return Feed
     */
    public function read(InputSource $inputSource, $validate, $tempPath = '')
    {
        if ($validate) {
            $this->validate($inputSource);
        }

        $xmlReader = $this->loadXmlReader($inputSource, $tempPath);

        $specDocument = $this->mode->getSpecDocument();
        $specItem = $this->mode->getSpecItem();

        // A container for the feed
        $feed = new Feed($this->mode);

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

        $this->logger->info('Basic feed info was loaded');

        // Iterate the item nodes
        do {
            if ($xmlReader->nodeType === \XMLReader::ELEMENT &&
                $xmlReader->depth === $baseDepthDocument &&
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
     * @param InputSource $inputSource
     * @param $tempPath
     * @return array
     */
    public function validate(InputSource $inputSource, $tempPath = '')
    {
        $xmlReader = $this->loadXmlReader($inputSource, $tempPath);

        $specDocument = $this->mode->getSpecDocument();
        $specItem = $this->mode->getSpecItem();

        $msgs = [];

        $valid = true;


        foreach (explode('/', $specDocument->getRoot()) as $pathPart) {
            do {
                $xmlReader->read();
            } while ($xmlReader->nodeType !== \XMLReader::ELEMENT && $xmlReader->nodeType !== 0);

            if ($xmlReader->name != $pathPart) {
                $valid = false;
                $msgs[] = sprintf(
                    "The root path must be '%s'",
                    $specDocument->getRoot()
                );
            }
        }

        $baseDepthDocument = $xmlReader->depth + 1;

        // Iterate the mandatory document elements
        $mandatoryElemsDocument = $specDocument->getMandatoryElems();

        while ($xmlReader->read() && count($mandatoryElemsDocument) > 0) {
            if ($xmlReader->nodeType === \XMLReader::ELEMENT && $xmlReader->depth === $baseDepthDocument) {
                if ($xmlReader->name === $specItem->getRoot()) {
                    $valid = false;
                    $msgs[] = sprintf(
                        "Not all mandatory document elements are present – elements '%s' are missing",
                        implode(', ', $mandatoryElemsDocument)
                    );
                    break;
                } elseif (($key = array_search($xmlReader->name, $mandatoryElemsDocument)) !== false) {
                    unset($mandatoryElemsDocument[$key]);
                }
            }
        }

        // Iterate the item nodes
        $itemCount = 0;

        do {
            if ($xmlReader->nodeType === \XMLReader::ELEMENT &&
                $xmlReader->depth === $baseDepthDocument &&
                $xmlReader->name === $specItem->getRoot()) {
                $itemCount++;

                $mandatoryElemsItem = $specItem->getMandatoryElems();

                $xmlElement = new \SimpleXMLElement($xmlReader->readOuterXML());

                // TODO - this is not the right way
                $lineNo = dom_import_simplexml($xmlElement)->getLineNo();

                foreach ($mandatoryElemsItem as $key => $mandatoryElemItem) {
                    if (isset($xmlElement->{$mandatoryElemItem})) {
                        unset($mandatoryElemsItem[$key]);
                    }
                }

                if (count($mandatoryElemsItem) > 0) {
                    $valid = false;
                    $msgs[] = sprintf(
                        "Not all mandatory elements are present in an entry beggining on line %u – elements '%s' 
                        are missing",
                        $lineNo,
                        implode(', ', $mandatoryElemsItem)
                    );
                }
            }
        } while ($xmlReader->next());

        $return['valid'] = $valid;
        $return['messages'] = $msgs;
        $return['item_count'] = $itemCount;

        return $return;
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
     * @param InputSource $inputSource
     * @param $tempPath
     * @return \XMLReader
     */
    private function loadXmlReader(InputSource $inputSource, $tempPath)
    {
        $xmlReader = new \XMLReader();

        /** @var TempResource $tempResource */
        $tempResource = $inputSource->createTempResource($tempPath);

        $xmlReader->open($tempResource->getResourceUri());

        return $xmlReader;
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
     * @return string|\DateTime
     */
    private function convertStringToDateTime($dateTimeString)
    {
        $convertedDateTimeString = \DateTime::createFromFormat($this->mode->getDateTimeFormat(), $dateTimeString);

        if ($convertedDateTimeString !== false) {
            return $convertedDateTimeString;
        }

        return $dateTimeString;
    }
}
