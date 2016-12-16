<?php

namespace Feedr\Specs;

use Feedr\Interfaces\Specs\Spec;
use Feedr\Specs\Atom\Document;
use Feedr\Specs\Atom\Item;

class Atom extends Spec
{

	const SPEC_NAME = 'Atom';

	public function __construct()
	{
		$this->specDocument = new Document();
		$this->specItem = new Item();
	}

	public function getSpecName()
	{
		return self::SPEC_NAME;
	}

}
