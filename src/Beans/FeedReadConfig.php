<?php

namespace Feedr\Beans;

use Feedr\Interfaces\Specs\Spec;
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

    public function __construct(
        Spec $spec,
        $tempPath,
        $logger = null
    ) {
        $this->spec = $spec;
        $this->tempPath = $tempPath;
        $this->logger = $this->initLogger($logger);
    }

    public function getSpec()
    {
        return $this->spec;
    }

    public function getTempPath()
    {
        return $this->tempPath;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setSpec(Spec $spec)
    {
        $this->spec = $spec;
    }

    public function setTempPath($tempPath)
    {
        $this->tempPath = $tempPath;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private function initLogger($logger)
    {
        if (!($logger instanceof LoggerInterface)) {
            $logger = new NullLogger();
        }

        return $logger;
    }
}
