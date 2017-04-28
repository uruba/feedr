<?php

namespace Feedr\Specs\Atom;

use Feedr\Core\Specs\SpecEntity;

/**
 * Class Document
 * @package Feedr\Specs\Atom
 */
class Document extends SpecEntity
{
    /** @return string[] */
    public function getXMLNamespaces()
    {
        return ['http://www.w3.org/2005/Atom'];
    }

    /** @return string */
    public function getRoot()
    {
        return 'feed';
    }

    /** @return string[] */
    public function getMandatoryElems()
    {
        return[
            'id',
            'title',
            'updated'
        ];
    }

    /** @return string[] */
    public function getOptionalElems()
    {
        return[
            'author',
            'link',
            'category',
            'contributor',
            'generator',
            'icon',
            'logo',
            'rights',
            'subtitle'
        ];
    }
}
