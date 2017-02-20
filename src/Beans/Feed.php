<?php

namespace Feedr\Beans;

use Feedr\Beans\Feed\FeedItem;
use Feedr\Interfaces\Spec;

/**
 * Class Feed
 * @package Feedr\Beans\Feed
 */
class Feed // TODO - a partial duplication of Feedr\Beans\Feed\FeedItem class?
{

    /** @var Spec */
    private $spec;

    /** @var FeedItem[] */
    private $items;

    /** @var string[] */
    private $vals = [];

    /**
     * Feed constructor.
     * @param Spec $spec
     */
    public function __construct(Spec $spec)
    {
        $this->spec = $spec;
    }

    /**
     * @param $name
     * @return string|null
     */
    public function __get($name)
    {
        if (in_array($name, $this->spec->getSpecDocument()->getAllElems())
                && isset($this->vals[$name])) {
            return $this->vals[$name];
        }

        return NULL;
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

    /**
     * @return FeedItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param FeedItem[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @param FeedItem $item
     */
    public function addItem(FeedItem $item)
    {
        $this->items[] = $item;
    }

    public function getSpec()
    {
        return $this->spec;
    }

}
