<?php

namespace Feedr\Beans;

class ValidationResult
{
    /** @var boolean */
    private $valid;

    /** @var string[] */
    private $messages;

    public function __construct($valid, $messages)
    {
        $this->valid = $valid;
        $this->messages = $messages;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @return \string[]
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
