<?php

namespace Feedr\Interfaces\Feed;

use Feedr\Interfaces\Spec;
use Feedr\Interfaces\Specs\SpecEntity;

abstract class FeedEntity
{
    /** @var Spec */
    protected $spec;

    /** @var array */
    protected $vals = [];

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
        if (in_array($name, $this->getSpecEntity()->getAllElems())
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
        if (in_array($name, $this->getSpecEntity()->getAllElems())) {
            $this->vals[$name] = $value;
        }
    }

    /**
     * @return Spec
     */
    public function getSpec()
    {
        return $this->spec;
    }

    /**
     * @return SpecEntity
     */
    abstract public function getSpecEntity();
}
