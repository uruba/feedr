<?php

namespace Feedr;

use Feedr\Core\Filtering\MultiValueFiltersWrapper;
use Feedr\Factories\ValueFilterFactory;
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
     * @param array $filters
     * @internal param Criterion $criterion
     * @return Core\Feed\Feed
     */
    public function readFeed(InputSource $inputSource, array $filters = [])
    {
        // TODO - the factory should maybe be a dependency of the entire Feedr class, do not create it here?
        $filters = (new ValueFilterFactory())->manufactureValueFilters($filters);
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
            $this->feedReadConfig->getSpec(),
            $validators
        );
    }
}
