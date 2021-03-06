<?php

namespace Feedr\Validators;

use Feedr\Core\Config\FeedReadConfig;
use Feedr\Core\Validation\ValidationResult;
use Feedr\Factories\XMLReaderFactory;
use Feedr\Core\Input\InputSource;
use Feedr\Core\Validation\Validator;

/**
 * Class RootElementValidator
 * @package Feedr\Validators
 */
class RootElementValidator implements Validator
{
    /**
     * @param FeedReadConfig $feedReadConfig
     * @param InputSource $inputSource
     * @return ValidationResult
     */
    public function validate(FeedReadConfig $feedReadConfig, InputSource $inputSource)
    {
        $xmlReader = XMLReaderFactory::manufactureXmlReader($inputSource, $feedReadConfig->getTempPath());

        $specDocument = $feedReadConfig->getSpec()->getSpecDocument();

        $msgs = [];

        $valid = true;

        foreach (explode('/', $specDocument->getRoot()) as $pathPart) {
            do {
                $xmlReader->read();
            } while ($xmlReader->nodeType !== \XMLReader::ELEMENT && $xmlReader->nodeType !== 0);

            if ($xmlReader->name != $pathPart) {
                $valid = false;
                $msgs[] = sprintf(
                    "The root path must be '%s'",
                    $specDocument->getRoot()
                );
            }
        }

        if ($valid) {
            $msgs[] = 'The root path is correct';
        }

        return new ValidationResult($valid, $msgs);
    }
}