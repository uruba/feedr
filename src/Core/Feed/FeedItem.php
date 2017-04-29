<?php

namespace Feedr\Core\Feed;

/**
 * Class FeedItem
 * @package Feedr\Core\Feed
 */
class FeedItem extends FeedEntity
{
    /**
     * @return \Feedr\Core\Specs\SpecEntity
     */
    public function getSpecEntity()
    {
        return $this->spec->getSpecItem();
    }
}
