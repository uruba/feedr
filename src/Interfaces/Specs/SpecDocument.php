<?php

namespace Feedr\Interfaces\Specs;

/**
 * Interface SpecDocument
 * @package Feedr\Interfaces\Specs
 */
interface SpecDocument
{

	/** @return string[] */
	public function getXMLNamespaces();

	/** @return string */
	public function getRoot();

	/** @return string[] */
	public function getMandatoryElems();

	/** @return string[] */
	public function getOptionalElems();

}
