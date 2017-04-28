<?php

namespace Feedr\Core\Caching;

/**
 * Interface TempResource
 * @package Feedr\Interfaces
 */
interface TempResource
{
    /**
     * @return string
     */
    public function getResourceUri();

    /**
     * @param $input
     */
    public function write($input);
}
