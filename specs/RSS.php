<?php

namespace Feedr\Specs;

use Feedr\Interfaces\Specs\Spec;
use Feedr\Specs\RSS\Document;
use Feedr\Specs\RSS\Item;

class RSS extends Spec
{

	const SPEC_NAME = 'RSS';

	public function __construct()
	{
		$this->specDocument = new Document();
		$this->specItem = new Item();
	}

	public function getSpecName()
	{
		return self::SPEC_NAME;
	}

	public function getDateTimeFormat()
	{
		return \DateTime::RSS;
	}

}
