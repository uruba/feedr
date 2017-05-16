<?php

namespace Feedr\Filters;

use Feedr\Core\Filtering\FilterCriterion;

/**
 * Class DateTimeFilter
 * @package Feedr\Filters
 */
class DateTimeFilter
{
    /**
     * @param \DateTime $refValue
     * @return FilterCriterion
     */
    public static function lowerThan(\DateTime $refValue)
    {
        return new FilterCriterion(
            function (\DateTime $fieldValue) use ($refValue) : bool {
                return $fieldValue < $refValue;
            }
        );
    }

    /**
     * @param \DateTime $refValue
     * @return FilterCriterion
     */
    public static function equals(\DateTime $refValue)
    {
        return new FilterCriterion(
            function (\DateTime $fieldValue) use ($refValue) : bool {
                return $fieldValue === $refValue;
            }
        );
    }

    /**
     * @param \DateTime $refValue
     * @return FilterCriterion
     */
    public static function greaterThan(\DateTime $refValue)
    {
        return new FilterCriterion(
            function (\DateTime $fieldValue) use ($refValue) : bool {
                return $fieldValue > $refValue;
            }
        );
    }

    public static function between(\DateTime $refValueLower, \DateTime $refValueUpper)
    {
        return new FilterCriterion(
            function (\DateTime $fieldValue) use ($refValueLower, $refValueUpper) : bool {
                return ($refValueLower < $fieldValue) && ($refValueUpper > $fieldValue);
            }
        );
    }
}
