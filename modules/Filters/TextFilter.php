<?php

namespace Feedr\Filters;

use Feedr\Core\Filtering\FilterCriterion;

/**
 * Class TextFilter
 * @package Feedr\Filters
 */
class TextFilter
{
    /**
     * @param string $refValue
     * @param bool $caseSensitive
     * @return FilterCriterion
     */
    public static function equals(string $refValue, bool $caseSensitive)
    {
        return new FilterCriterion(
            function ($fieldValue) use ($refValue, $caseSensitive) : bool {
                $fieldValue = strval($fieldValue);

                if ($caseSensitive) {
                    $comparisonResult = strcmp($fieldValue, $refValue);
                } else {
                    $comparisonResult = strcasecmp($fieldValue, $refValue);
                }

                return $comparisonResult === 0;
            }
        );
    }

    /**
     * @param string $refValue
     * @param bool $caseSensitive
     * @return FilterCriterion
     */
    public static function contains(string $refValue, bool $caseSensitive)
    {
        return new FilterCriterion(
            function ($fieldValue) use ($refValue, $caseSensitive) : bool {
                $fieldValue = strval($fieldValue);

                if ($caseSensitive) {
                    $comparisonResult = strpos($fieldValue, $refValue);
                } else {
                    $comparisonResult = stripos($fieldValue, $refValue);
                }

                return $comparisonResult !== false;
            }
        );
    }
}
