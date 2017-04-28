<?php

namespace Feedr\Interfaces\Specs;

/**
 * Class Spec
 * @package Feedr\Interfaces\Specs
 */
abstract class Spec
{
    /** @var SpecEntity */
    protected $specDocument;

    /** @var SpecEntity */
    protected $specItem;

    /**
     * Spec constructor.
     */
    abstract public function __construct();

    /** @return SpecEntity */
    public function getSpecDocument()
    {
        return $this->specDocument;
    }

    /** @return SpecEntity */
    public function getSpecItem()
    {
        return $this->specItem;
    }

    /** @return string */
    abstract public function getName();

    /** @return string */
    abstract public function getDateTimeFormat();
}
