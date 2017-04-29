<?php

namespace Feedr\Factories;

use Feedr\Core\Filtering\FilterCriterion;
use Feedr\Core\Filtering\ValueFilter;

class ValueFilterFactory
{
    /**
     * @param array $filterDefinitions
     * @return array
     */
    public function manufactureValueFilters(array $filterDefinitions)
    {
        $valueFilters = [];

        foreach ($filterDefinitions as $fieldName => $filterCriterion) {
            if (is_string($fieldName) && $filterCriterion instanceof FilterCriterion) {
                $valueFilters[] = new ValueFilter($fieldName, $filterCriterion);
            }
        }

        return $valueFilters;
    }
}
