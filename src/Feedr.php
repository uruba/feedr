<?php

namespace Feedr;

use Feedr\Core\Filtering\MultiValueFiltersWrapper;
use Feedr\Factories\ValueFilterFactory;
use Feedr\Core\Config\FeedReadConfig;
use Feedr\Core\Validation\ValidationResult;
use Feedr\Core\Reader;
use Feedr\Core\Validation\ValidatorWrapper;
use Feedr\Core\Input\InputSource;
use Feedr\Core\Validation\Validator;

/**
 * Class Feedr
 * @package Feedr
 */
class Feedr
{
    /** @var Reader */
    private $reader;

    /** @var ValueFilterFactory */
    private $valueFilterFactory;

    /**
     * Feedr constructor.
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->setReader($reader);

        // TODO - maybe figure out a cleaner way?
        $this->injectValueFilterFactory(new ValueFilterFactory());
    }

    /**
     * @return Reader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param Reader $reader
     */
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param FeedReadConfig $feedReadConfig
     */
    public function changeReaderConfig(FeedReadConfig $feedReadConfig)
    {
        $this->reader->setFeedReadConfig($feedReadConfig);
    }

    /**
     * @param ValueFilterFactory $valueFilterFactory
     */
    public function injectValueFilterFactory(ValueFilterFactory $valueFilterFactory)
    {
        $this->valueFilterFactory = $valueFilterFactory;
    }

    /**
     * @param InputSource $inputSource
     * @param array $filters
     * @internal param Criterion $criterion
     * @return Core\Feed\Feed
     */
    public function readFeed(InputSource $inputSource, array $filters = [])
    {
        $filters = $this->valueFilterFactory->manufactureValueFilters($filters);
        return $this->reader->read($inputSource, new MultiValueFiltersWrapper($filters));
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
            $this->reader->getFeedReadConfig(),
            $validators
        );
    }
}
