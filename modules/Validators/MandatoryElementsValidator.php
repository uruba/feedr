<?php

namespace Feedr\Validators;

use Feedr\Core\Config\FeedReadConfig;
use Feedr\Core\Validation\ValidationResult;
use Feedr\Factories\XMLReaderFactory;
use Feedr\Core\Input\InputSource;
use Feedr\Core\Validation\Validator;

/**
 * Class MandatoryElementsValidator
 * @package Feedr\Core
 */
class MandatoryElementsValidator implements Validator
{
    /**
     * @param FeedReadConfig $feedReadConfig
     * @param InputSource $inputSource
     * @return ValidationResult
     */
    public function validate(FeedReadConfig $feedReadConfig, InputSource $inputSource)
    {
        $xmlReader = XMLReaderFactory::manufactureXmlReader($inputSource, $feedReadConfig->getTempPath());

        $spec = $feedReadConfig->getSpec();
        $specDocument = $spec->getSpecDocument();
        $specItem = $spec->getSpecItem();

        $msgs = [];

        $valid = true;

        $baseDepthDocument = $xmlReader->depth + 1;

        // Iterate the mandatory document elements
        $mandatoryElemsDocument = $specDocument->getMandatoryElems();

        while ($xmlReader->read() && count($mandatoryElemsDocument) > 0) {
            if ($xmlReader->nodeType === \XMLReader::ELEMENT && $xmlReader->depth === $baseDepthDocument) {
                if ($xmlReader->name === $specItem->getRoot()) {
                    $valid = false;
                    $msgs[] = sprintf(
                        "Not all mandatory document elements are present – elements '%s' are missing",
                        implode(', ', $mandatoryElemsDocument)
                    );
                    break;
                } elseif (($key = array_search($xmlReader->name, $mandatoryElemsDocument)) !== false) {
                    unset($mandatoryElemsDocument[$key]);
                }
            }
        }

        // Iterate the item nodes
        do {
            if ($xmlReader->nodeType === \XMLReader::ELEMENT &&
                $xmlReader->depth === $baseDepthDocument &&
                $xmlReader->name === $specItem->getRoot()) {
                $mandatoryElemsItem = $specItem->getMandatoryElems();

                $xmlElement = new \SimpleXMLElement($xmlReader->readOuterXML());

                // TODO - this is not the right way
                $lineNo = dom_import_simplexml($xmlElement)->getLineNo();

                foreach ($mandatoryElemsItem as $key => $mandatoryElemItem) {
                    if (isset($xmlElement->{$mandatoryElemItem})) {
                        unset($mandatoryElemsItem[$key]);
                    }
                }

                if (count($mandatoryElemsItem) > 0) {
                    $valid = false;
                    $msgs[] = sprintf(
                        "Not all mandatory elements are present in an entry beginning on line %u – elements '%s' 
                        are missing",
                        $lineNo,
                        implode(', ', $mandatoryElemsItem)
                    );
                }
            }
        } while ($xmlReader->next());

        if ($valid) {
            $msgs[] = 'All mandatory elements are present';
        }

        return new ValidationResult($valid, $msgs);
    }
}
