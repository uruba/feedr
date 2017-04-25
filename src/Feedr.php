<?php

namespace Feedr;

use Feedr\Beans\FeedReadConfig;
use Feedr\Core\Reader;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Spec;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Feedr
 * @package Feedr
 */
class Feedr
{
    /** @var Reader */
    private $reader;

    /**
     * Feedr constructor.
     * @param Spec $mode
     * @param string $tempPath
     * @param $logger
     */
    public function __construct(Spec $mode, $tempPath = '', $logger = null)
    {
        if (!($logger instanceof LoggerInterface)) {
            $logger = new NullLogger();
        }

        $this->reader = new Reader(new FeedReadConfig($mode, $tempPath, $logger));
    }

    /**
     * @param InputSource $inputSource
     * @param bool $validate
     * @return Beans\Feed
     */
    public function readFeed(InputSource $inputSource, $validate = true)
    {
        // TODO - connect the validation mechanism
        return $this->reader->read($inputSource);
    }

    /**
     * @param InputSource $inputSource
     * @param \DateTime $dateTime
     */
    public function readFeedConstraintFrom(InputSource $inputSource, \DateTime $dateTime)
    {
        // TODO - read only feed from a specified date(time) forth
    }

    /**
     * @param InputSource $inputSource
     * @return array
     */
    public function validateFeed(InputSource $inputSource, $validators)
    {
        // TODO - implement separate validation
    }
}
