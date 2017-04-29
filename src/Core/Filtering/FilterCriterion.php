<?php

namespace Feedr\Core\Filtering;

use Feedr\Exceptions\InvalidComparisionCallbackException;

class FilterCriterion
{
    /**
     * @var \Closure
     */
    private $comparisionCallback;

    /**
     * Criterion constructor.
     * @param \Closure $comparisionCallback
     * @internal param string $fieldName
     */
    public function __construct(\Closure $comparisionCallback)
    {
        $this->validateComparisionCallback($comparisionCallback);
        $this->comparisionCallback = $comparisionCallback;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isCompare($value)
    {
        $comparisionCallback = $this->comparisionCallback;
        return $comparisionCallback($value);
    }

    /**
     * @param \Closure $comparisionCallback
     */
    private function validateComparisionCallback(\Closure $comparisionCallback)
    {
        $reflectionFunction = new \ReflectionFunction($comparisionCallback);

        if ($reflectionFunction->getNumberOfParameters() !== 1) {
            throw new InvalidComparisionCallbackException(
                sprintf(
                    'The comparision callback function must take in exactly 1 parameter,
                     %d specified',
                    $reflectionFunction->getNumberOfParameters()
                )
            );
        }

        if (strval($reflectionFunction->getReturnType()) !== "bool") {
            throw new InvalidComparisionCallbackException(
                sprintf(
                    'The comparision callback function must have its return type specified as \'bool\',
                     \'%s\' given instead',
                    strval($reflectionFunction->getReturnType())
                )
            );
        }
    }
}
