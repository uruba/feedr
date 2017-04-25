<?php

namespace Feedr\Factories;

use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\TempResource;

class XMLReaderFactory
{
    /**
     * @param InputSource $inputSource
     * @param $tempPath
     * @return \XMLReader
     */
    public static function manufactureXmlReader(InputSource $inputSource, $tempPath = '')
    {
        $xmlReader = new \XMLReader();

        /** @var TempResource $tempResource */
        $tempResource = $inputSource->createTempResource($tempPath);

        $xmlReader->open($tempResource->getResourceUri());

        return $xmlReader;
    }
}
