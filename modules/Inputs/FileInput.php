<?php

namespace Feedr\Inputs;

use Feedr\Core\Input\InputSource;

/**
 * Class FileInput
 * @package Feedr\Inputs
 */
class FileInput extends InputSource
{
    const FILENAME_PREFIX = 'file';

    /** @var string */
    private $sourceFilePath;

    /**
     * FileInput constructor.
     * @param $sourceFilePath
     */
    public function __construct($sourceFilePath)
    {
        $this->sourceFilePath = $sourceFilePath;
    }

    /**
     * @return mixed
     */
    public function createStream()
    {
        return file_get_contents($this->sourceFilePath);
    }

    /**
     * @return string[]
     */
    public function getTempFileNameMeta()
    {
        $baseName = explode('.', basename($this->sourceFilePath));
        $fileMeta['file_name'] = $baseName[0];

        return $fileMeta;
    }

    /** @return string */
    public function getTempFileNamePrefix()
    {
        return self::FILENAME_PREFIX;
    }
}
