<?php

namespace Feedr\Core\Specs;

/**
 * Class SpecEntity
 * @package Feedr\Interfaces\Specs
 */
abstract class SpecEntity
{
    /** @return string[] */
    abstract public function getXMLNamespaces();
    
    /** @return string */
    abstract public function getRoot();
    
    /** @return string[] */
    abstract public function getMandatoryElems();
    
    /** @return string[] */
    abstract public function getOptionalElems();
    
    /**
     * @return \string[]
     */
    public function getAllElems()
    {
        return $this->getMandatoryElems() + $this->getOptionalElems();
    }
}
