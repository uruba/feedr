<?php

namespace Feedr\Core\Feed;

/**
 * Class Feed
 * @package Feedr\Beans\Feed
 */
class Feed extends FeedEntity
{
    /** @var FeedItem[] */
    private $items;

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

    /**
     * @return \Feedr\Core\Specs\SpecEntity
     */
    public function getSpecEntity()
    {
        return $this->spec->getSpecDocument();
    }
}
