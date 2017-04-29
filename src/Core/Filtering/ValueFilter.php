<?php

namespace Feedr\Core\Filtering;

use Feedr\Core\Feed\FeedItem;

class ValueFilter
{
    const REFERENCE_TYPE = null;

    /** @var string */
    private $fieldName;

    /** @var FilterCriterion */
    private $criterion;

    final public function __construct(string $fieldName, FilterCriterion $criterion)
    {
        $this->fieldName = $fieldName;
        $this->criterion = $criterion;
    }

    /**
     * @param FeedItem $feedItem
     * @return mixed
     */
    public function isItemValid(FeedItem $feedItem)
    {
        return $this->criterion->isCompare($feedItem->{$this->fieldName});
    }
}
