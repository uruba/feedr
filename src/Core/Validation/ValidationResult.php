<?php

namespace Feedr\Core\Validation;

/**
 * Class ValidationResult
 * @package Feedr\Core\Validation
 */
class ValidationResult
{
    /** @var boolean */
    private $valid;

    /** @var string[] */
    private $messages;

    /**
     * ValidationResult constructor.
     * @param $valid
     * @param $messages
     */
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
