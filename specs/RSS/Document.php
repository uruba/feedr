<?php

namespace Feedr\Specs\RSS;

use Feedr\Interfaces\Specs\SpecDocument;

/**
 * Class Document
 * @package Feedr\Specs\RSS
 */
class Document implements SpecDocument
{

	/** @return string[] */
	public function getXMLNamespaces()
	{
		return [];
	}

	/** @return string */
	public function getRoot()
	{
		return 'rss/channel';
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
	public function getPathCreated()
	{
		return 'pubDate';
	}

	/** @return string */
	public function getPathUpdated()
	{
		return 'lastBuildDate';
	}

}
