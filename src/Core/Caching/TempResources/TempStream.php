<?php

namespace Feedr\Core\Caching\TempResources;

use Feedr\Core\Caching\TempResource;

/**
 * Class TempStream
 * @package Feedr\Core\Caching\TempResources
 */
class TempStream implements TempResource
{
    /**
     * @var resource
     */
    private $tempHandle;

    /**
     * TempStream constructor.
     */
    public function __construct()
    {
        $this->tempHandle = $this->createNewTempStream();
    }

    /**
     * @return string|null
     */
    public function getResourceUri()
    {
        return stream_get_meta_data($this->tempHandle)['uri'];
    }

    /**
     * @param $input
     */
    public function write($input)
    {
        fwrite($this->tempHandle, $input);
    }

    /**
     * @return resource
     */
    private function createNewTempStream()
    {
        return tmpfile(); // TODO - find out a way how to get this working with 'php://temp'
    }
}
