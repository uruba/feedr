<?php

namespace Feedr\Interfaces;

use Feedr\Interfaces\Specs\SpecEntity;

/**
 * Class Spec
 * @package Feedr\Interfaces\Specs
 */
abstract class Spec
{

	/** @var SpecEntity */
	protected $specDocument;

	/** @var SpecEntity */
	protected $specItem;

	/**
	 * Spec constructor.
	 */
	abstract public function __construct();

	/** @return SpecEntity */
	public function getSpecDocument()
	{
		return $this->specDocument;
	}

	/** @return SpecEntity */
	public function getSpecItem()
	{
		return $this->specItem;
	}

	/** @return string */
	abstract public function getSpecName();

	/** @return string */
	abstract public function getDateTimeFormat();

}