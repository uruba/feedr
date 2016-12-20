<?php

namespace Feedr\Interfaces\Specs;

/**
 * Interface SpecItem
 * @package Feedr\Interfaces\Specs
 */
interface SpecItem
{

	/** @return string */
	public function getRoot();

	/** @return string[] */
	public function getMandatoryElems();

	/** @return string[] */
	public function getOptionalElems();

}
