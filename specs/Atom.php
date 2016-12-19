<?php

namespace Feedr\Specs;

use Feedr\Interfaces\Specs\Spec;
use Feedr\Specs\Atom\Document;
use Feedr\Specs\Atom\Item;

/**
 * Class Atom
 * @package Feedr\Specs
 */
class Atom extends Spec
{

	const SPEC_NAME = 'Atom';

	/**
	 * Atom constructor.
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
		return \DateTime::ATOM;
	}

}
