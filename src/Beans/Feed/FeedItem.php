<?php

namespace Feedr\Beans\Feed;

use Feedr\Interfaces\Feed\FeedEntity;

/**
 * Class FeedItem
 * @package Feedr\Beans\Feed
 */
class FeedItem extends FeedEntity
{
    /**
     * @return \Feedr\Interfaces\Specs\SpecEntity
     */
    public function getSpecEntity()
    {
        return $this->spec->getSpecItem();
    }
}
