<?php

namespace Feedr\Interfaces;

use Feedr\Beans\ValidationResult;

interface Validator
{
    /**
     * @param InputSource $inputSource
     * @param string $tempPath
     * @return ValidationResult
     */
    public function validate(InputSource $inputSource, $tempPath = '');
}
