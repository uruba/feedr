<?php

namespace Feedr\Core\Validation;

use Feedr\Core\Config\FeedReadConfig;
use Feedr\Core\Input\InputSource;

/**
 * Interface Validator
 * @package Feedr\Core\Validation
 */
interface Validator
{
    /**
     * @param FeedReadConfig $feedReadConfig
     * @param InputSource $inputSource
     * @return ValidationResult
     */
    public function validate(FeedReadConfig $feedReadConfig, InputSource $inputSource);
}
