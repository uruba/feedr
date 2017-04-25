<?php

namespace Feedr\Validators;

use Feedr\Beans\ValidationResult;
use Feedr\Factories\XMLReaderFactory;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Spec;
use Feedr\Interfaces\Validator;

class RootElementValidator implements Validator
{
    /** @var Spec */
    private $mode;

    public function __construct(Spec $mode)
    {
        $this->mode = $mode;
    }

    /**
     * @param InputSource $inputSource
     * @param string $tempPath
     * @return ValidationResult
     */
    public function validate(InputSource $inputSource, $tempPath = '')
    {
        $xmlReader = XMLReaderFactory::manufactureXmlReader($inputSource, $tempPath);

        $specDocument = $this->mode->getSpecDocument();

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

        return new ValidationResult($valid, $msgs);
    }
}