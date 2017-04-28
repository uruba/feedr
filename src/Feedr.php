<?php

namespace Feedr;

use Feedr\Core\Config\FeedReadConfig;
use Feedr\Core\Validation\ValidationResult;
use Feedr\Core\Reader;
use Feedr\Core\Validation\ValidatorWrapper;
use Feedr\Core\Input\InputSource;
use Feedr\Core\Specs\Spec;
use Feedr\Core\Validation\Validator;

/**
 * Class Feedr
 * @package Feedr
 */
class Feedr
{
    /** @var Reader */
    private $reader;

    /** @var FeedReadConfig */
    private $feedReadConfig;

    /**
     * Feedr constructor.
     * @param Spec $mode
     * @param string $tempPath
     * @param $logger
     */
    public function __construct(Spec $mode, $tempPath = '', $logger = null)
    {
        $this->feedReadConfig = new FeedReadConfig($mode, $tempPath, $logger);

        $this->reader = new Reader($this->feedReadConfig);
    }

    /**
     * @param InputSource $inputSource
     * @return \Feedr\Core\Feed\Feed
     */
    public function readFeed(InputSource $inputSource)
    {
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
     * @param Validator[]|Validator $validators
     * @return ValidationResult
     */
    public function validateFeed(InputSource $inputSource, $validators)
    {
        $validatorWrapper = new ValidatorWrapper($inputSource);

        return $validatorWrapper->validateFeed(
            $this->feedReadConfig->getSpec(),
            $validators
        );
    }
}
