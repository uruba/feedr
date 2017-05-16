<?php

namespace Feedr\Core\Filtering;

use Feedr\Core\Feed\FeedItem;

/**
 * Class MultiValueFiltersWrapper
 * @package Feedr\Core\Filtering
 */
class MultiValueFiltersWrapper
{
    /** @var ValueFilter[] */
    private $valueFilters = [];

    /**
     * ValueFiltersWrapper constructor.
     * @param array $valueFilters
     */
    public function __construct(array $valueFilters)
    {
        if (!empty($valueFilters)) {
            foreach ($valueFilters as $valueFilter) {
                if ($valueFilter instanceof ValueFilter) {
                    $this->valueFilters[] = $valueFilter;
                }
            }
        }
    }

    /**
     * @param FeedItem $feedItem
     * @return mixed
     */
    public function isItemValid(FeedItem $feedItem)
    {
        $valid = true;

        /** @var ValueFilter $valueFilter */
        foreach ($this->valueFilters as $valueFilter) {
            if (!$valueFilter->isItemValid($feedItem)) {
                $valid = false;
                break;
            }
        }

        return $valid;
    }
}
