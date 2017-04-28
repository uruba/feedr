<?php

namespace Feedr\Core\Validation;

use Feedr\Core\Input\InputSource;
use Feedr\Core\Specs\Spec;

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
