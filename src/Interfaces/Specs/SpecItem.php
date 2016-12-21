<?php

namespace Feedr\Interfaces\Specs;

/**
 * Class SpecItem
 * @package Feedr\Interfaces\Specs
 */
abstract class SpecItem
{

	/** @return string */
	public abstract function getRoot();

	/** @return string[] */
	public abstract function getMandatoryElems();

	/** @return string[] */
	public abstract function getOptionalElems();

	/**
	 * @return \string[]
	 */
	public function getAllElems() {
		return $this->getMandatoryElems() + $this->getOptionalElems();
	}

}
