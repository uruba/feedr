<?php

namespace Feedr\Specs;

use Feedr\Interfaces\Spec;
use Feedr\Specs\RSS\Document;
use Feedr\Specs\RSS\Item;

/**
 * Class RSS
 * @package Feedr\Specs
 */
class RSS extends Spec
{

	const SPEC_NAME = 'RSS';

	/**
	 * RSS constructor.
	 */
	public function __construct()
	{
		$this->specDocument = new Document();
		$this->specItem = new Item();
	}

	/**
	 * @return string
	 */
	public function getSpecName()
	{
		return self::SPEC_NAME;
	}

	/**
	 * @return string
	 */
	public function getDateTimeFormat()
	{
		return \DateTime::RSS;
	}

}
