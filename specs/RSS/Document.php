<?php

namespace Feedr\Specs\RSS;

use Feedr\Interfaces\Specs\SpecDocument;

/**
 * Class Document
 * @package Feedr\Specs\RSS
 */
class Document extends SpecDocument
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

	/** @return string[] */
	public function getMandatoryElems()
	{
		return[
			'title',
			'link',
			'description'
		];
	}

	/** @return string[] */
	public function getOptionalElems()
	{
		return[
			'language',
			'copyright',
			'managingEditor',
			'webMaster',
			'pubDate',
			'lastBuildDate',
			'category',
			'generator',
			'docs',
			'cloud',
			'ttl',
			'image',
			'textInput',
			'skipHours',
			'skipDays'
		];
	}

}
