<?php

namespace Feedr\Core\Input;

use Feedr\Core\Caching\TempResource;
use Feedr\Core\Caching\TempResources\TempFile;
use Feedr\Core\Caching\TempResources\TempStream;

/**
 * Class InputSource
 * @package Feedr\Interfaces
 */
abstract class InputSource
{
    const FILENAME_PREFIX = 'temp';
    
    /**
     * @return mixed
     */
    abstract public function createStream();
    
    /**
     * @return string[]
     */
    abstract public function getTempFileNameMeta();
    
    /**
     * @param string $tempPath
     * @return TempResource
     */
    public function createTempResource($tempPath)
    {
        // initialize the temp file/stream
        if (empty($tempPath)) {
            $tempFile = new TempStream();
        } else {
            $tempFile = new TempFile($tempPath, self::FILENAME_PREFIX, $this->getTempFileNameMeta());
        }
    
        // populate the temp file
        $tempFile->write($this->createStream());
    
        return $tempFile;
    }
}
