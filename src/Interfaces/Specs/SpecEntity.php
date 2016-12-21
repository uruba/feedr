<?php

namespace Feedr\Interfaces\Specs;

/**
 * Class SpecEntity
 * @package Feedr\Interfaces\Specs
 */
abstract class SpecEntity
{

	/** @return string[] */
	public abstract function getXMLNamespaces();

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
