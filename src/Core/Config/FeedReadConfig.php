<?php

namespace Feedr\Core\Config;

use Feedr\Core\Specs\Spec;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class FeedReadConfig
{
    /** @var Spec */
    private $spec;

    /** @var string */
    private $tempPath;

    /** @var LoggerInterface */
    private $logger;

    /**
     * FeedReadConfig constructor.
     * @param Spec $spec
     * @param string $tempPath
     * @param null $logger
     */
    public function __construct(
        Spec $spec,
        $tempPath = '',
        $logger = null
    ) {
        $this->spec = $spec;
        $this->tempPath = $tempPath;
        $this->logger = $this->initLogger($logger);
    }

    /**
     * @return Spec
     */
    public function getSpec()
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
     * @return LoggerInterface|NullLogger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param Spec $spec
     */
    public function setSpec(Spec $spec)
    {
        $this->spec = $spec;
    }

    /**
     * @param $tempPath
     */
    public function setTempPath($tempPath)
    {
        $this->tempPath = $tempPath;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $logger
     * @return NullLogger
     */
    private function initLogger($logger)
    {
        if (!($logger instanceof LoggerInterface)) {
            $logger = new NullLogger();
        }

        return $logger;
    }
}
