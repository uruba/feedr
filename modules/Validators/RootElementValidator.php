<?php

namespace Feedr\Validators;

use Feedr\Core\Validation\ValidationResult;
use Feedr\Factories\XMLReaderFactory;
use Feedr\Core\Input\InputSource;
use Feedr\Core\Specs\Spec;
use Feedr\Core\Validation\Validator;

class RootElementValidator implements Validator
{
    /**
     * @param Spec $spec
     * @param InputSource $inputSource
     * @param string $tempPath
     * @return ValidationResult
     */
    public function validate(Spec $spec, InputSource $inputSource, $tempPath = '')
    {
        $xmlReader = XMLReaderFactory::manufactureXmlReader($inputSource, $tempPath);

        $specDocument = $spec->getSpecDocument();

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