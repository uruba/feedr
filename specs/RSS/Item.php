<?php

namespace Feedr\Specs\RSS;

use Feedr\Interfaces\Specs\SpecItem;

class Item implements SpecItem
{

	/** @return string */
	public function getPathRoot()
	{
		return 'item';
	}

	/** @return string */
	public function getPathTitle()
	{
		return 'title';
	}

	/** @return string */
	public function getPathLink()
	{
		return 'link';
	}

	/** @return string */
	public function getPathSummary()
	{
		return 'description';
	}

	/** @return string */
	public function getPathContent()
	{
		return '';
	}

	/** @return string */
	public function getPathAuthor()
	{
		return 'author';
	}

}
