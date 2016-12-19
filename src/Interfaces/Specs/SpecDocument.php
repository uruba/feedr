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

	/** @return string */
	public function getPathTitle();

	/** @return string */
	public function getPathLink();

	/** @return string */
	public function getPathCreated();

	/** @return string */
	public function getPathUpdated();

}
