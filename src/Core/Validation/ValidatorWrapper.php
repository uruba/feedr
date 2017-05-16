<?php

namespace Feedr\Core\Validation;

use Feedr\Core\Config\FeedReadConfig;
use Feedr\Exceptions\NoValidValidatorsException;
use Feedr\Core\Input\InputSource;

/**
 * Class ValidatorWrapper
 * @package Feedr\Core\Validation
 */
class ValidatorWrapper
{
    /** @var InputSource */
    private $inputSource;

    /**
     * ValidatorWrapper constructor.
     * @param InputSource $inputSource
     */
    public function __construct(InputSource $inputSource)
    {
        $this->inputSource = $inputSource;
    }

    /**
     * @param FeedReadConfig $feedReadConfig
     * @param $validators
     * @return ValidationResult
     */
    public function validateFeed(FeedReadConfig $feedReadConfig, $validators)
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
            $feedReadConfig
        ) {
            $noValidValidators = false;
            $validationResult = $validator->validate(
                $feedReadConfig,
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