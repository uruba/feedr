<?php

namespace Feedr\Specs\Atom;

use Feedr\Interfaces\Specs\SpecEntity;

/**
 * Class Item
 * @package Feedr\Specs\Atom
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
        return 'entry';
    }

    /** @return string[] */
    public function getMandatoryElems()
    {
        return [
            'id',
            'title',
            'updated'
        ];
    }

    /** @return string[] */
    public function getOptionalElems()
    {
        return [
            'author',
            'content',
            'link',
            'summary',
            'category',
            'contributor',
            'published',
            'rights',
            'source'
        ];
    }

}
