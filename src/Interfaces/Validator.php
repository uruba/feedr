<?php

namespace Feedr\Interfaces;

use Feedr\Beans\ValidationResult;
use Feedr\Interfaces\Specs\Spec;

interface Validator
{
    /**
     * @param Spec $spec
     * @param InputSource $inputSource
     * @param string $tempPath
     * @return ValidationResult
     */
    public function validate(Spec $spec, InputSource $inputSource, $tempPath = '');
}
