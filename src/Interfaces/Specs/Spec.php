<?php

namespace Feedr\Interfaces\Specs;

/**
 * Class Spec
 * @package Feedr\Interfaces\Specs
 */
abstract class Spec
{

	/** @var SpecDocument */
	protected $specDocument;

	/** @var SpecItem */
	protected $specItem;

	/**
	 * Spec constructor.
	 */
	abstract public function __construct();

	/** @return SpecDocument */
	public function getSpecDocument()
	{
		return $this->specDocument;
	}

	/** @return SpecItem */
	public function getSpecItem()
	{
		return $this->specItem;
	}

	/** @return string */
	abstract public function getSpecName();

	/** @return string */
	abstract public function getDateTimeFormat();

}
