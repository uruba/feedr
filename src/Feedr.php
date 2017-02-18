<?php

namespace Feedr;

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

    /** @var string */
    private $tempPath = '';

    /** @var Reader */
    private $reader;

    /** @var Spec */
    private $spec;

    /**
     * Feedr constructor.
     * @param Spec $mode
     */
    public function __construct(Spec $mode)
    {
        $this->spec = $mode;

        $this->reader = new Reader($this->spec, new NullLogger());
    }

    /**
     * @param InputSource $inputSource
     * @param bool $validate
     * @return Beans\Feed
     */
    public function readFeed(InputSource $inputSource, $validate = true)
    {
        return $this->reader->read($inputSource, $validate, $this->tempPath);
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
    public function validateFeed(InputSource $inputSource)
    {
        return $this->reader->validate($inputSource, $this->tempPath);
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->reader->getLogger();
    }

    /**
     * @return Spec
     */
    public function getMode()
    {
        return $this->spec;
    }

    /**
     * @return string
     */
    public function getTempPath()
    {
        return $this->tempPath;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->reader->setLogger($logger);
    }

    /**
     * @param Spec $mode
     */
    public function setMode(Spec $mode)
    {
        $this->spec = $mode;
    }

    /**
     * @param string $tempPath
     */
    public function setTempPath($tempPath)
    {
        $this->tempPath = $tempPath;
    }

}
