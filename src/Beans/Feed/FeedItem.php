<?php

namespace Feedr\Beans\Feed;

use Feedr\Interfaces\Spec;

/**
 * Class FeedItem
 * @package Feedr\Beans\Feed
 */
class FeedItem // TODO - a partial duplication of Feedr\Beans\Feed class?
{
    /** @var Spec */
    private $spec;

    /** @var array */
    private $vals = [];

    /**
     * FeedItem constructor.
     * @param Spec $spec
     */
    public function __construct(Spec $spec)
    {
        $this->spec = $spec;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (in_array($name, $this->spec->getSpecItem()->getAllElems())
            && isset($this->vals[$name])) {
            return $this->vals[$name];
        }

        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->spec->getSpecDocument()->getAllElems())) {
            $this->vals[$name] = $value;
        }
    }
}
