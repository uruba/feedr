<?php

namespace Feedr\Core;

use Feedr\Beans\ValidationResult;
use Feedr\Exceptions\NoValidValidatorsException;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Spec;
use Feedr\Interfaces\Validator;

class ValidatorWrapper
{
    /** @var InputSource */
    private $inputSource;

    public function __construct(InputSource $inputSource)
    {
        $this->inputSource = $inputSource;
    }

    public function validateFeed(Spec $spec, $validators)
    {
        $noValidValidators = true;

        $isDocumentValid = true;
        $messages = [];

        /**
         * @param Validator $validator
         */
        $runValidator = function (Validator $validator) use (
            &$noValidValidators,
            &$isDocumentValid,
            &$messages,
            $spec
        ) {
            $noValidValidators = false;
            $validationResult = $validator->validate(
                $spec,
                $this->inputSource
            );

            if ($isDocumentValid && !$validationResult->isValid()) {
                $isDocumentValid = false;
            }

            $messages = array_merge($messages, $validationResult->getMessages());
        };

        if (is_array($validators)) {
            foreach ($validators as $validator) {
                if ($validator instanceof Validator) {
                    $runValidator($validator);
                }
            }
        } elseif ($validators instanceof Validator) {
            $runValidator($validators);
        }

        if ($noValidValidators) {
            throw new NoValidValidatorsException(
                'No valid validators were passed as an array, nor as a single validator object'
            );
        }

        return new ValidationResult($isDocumentValid, $messages);
    }
}