<?php

namespace Feedr\Interfaces\Specs;

interface SpecItem
{

	/** @return string */
	public function getRoot();

	/** @return string */
	public function getPathTitle();

	/** @return string */
	public function getPathLink();

	/** @return string */
	public function getPathSummary();

	/** @return string */
	public function getPathContent();

	/** @return string */
	public function getPathAuthor();

}
