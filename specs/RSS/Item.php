<?php

namespace Feedr\Specs\RSS;

use Feedr\Interfaces\Specs\SpecEntity;

/**
 * Class Item
 * @package Feedr\Specs\RSS
 */
class Item extends SpecEntity
{

    /** @return string[] */
    public function getXMLNamespaces()
    {
        return [];
    }

    /** @return string */
    public function getRoot()
    {
        return 'item';
    }

    /**
     * @return string[]
     */
    public function getMandatoryElems()
    {
        return [
            'title',
            'description'
        ];
    }

    /**
     * @return string[]
     */
    public function getOptionalElems()
    {
        return[
            'link',
            'author',
            'category',
            'comments',
            'enclosure',
            'guid',
            'pubDate',
            'source'
        ];
    }

}
