<?php

namespace Feedr\Inputs;

use Feedr\Core\Input\InputSource;

/**
 * Class StringInput
 * @package Feedr\Inputs
 */
class StringInput extends InputSource
{
    /** @var StringInput */
    private $feedString;

    /**
     * StringInput constructor.
     * @param $feedString
     */
    public function __construct($feedString)
    {
        $this->feedString = $feedString;
    }

    /**
     * @param StringInput $tempPath
     * @return \Feedr\Core\Caching\TempResources\TempFile
     */
    public function createTempResource($tempPath)
    {
        // TODO: Implement createTempFile() method.
    }

    /**
     * @return mixed
     */
    public function createStream()
    {
        // TODO: Implement createStream() method.
    }

    /**
     * @return string[]
     */
    public function getTempFileNameMeta()
    {
        // TODO: Implement getTempFileNameMeta() method.
    }
}
