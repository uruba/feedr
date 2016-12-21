<?php

namespace Feedr\Inputs;

use Feedr\Interfaces\InputSource;

/**
 * Class StringInput
 * @package Feedr\Inputs
 */
class StringInput extends InputSource
{

	/** @var StringInput */
	private $feedString;

	/**
	 * StringInput constructor.
	 * @param $feedString
	 */
	public function __construct($feedString)
	{
		$this->feedString = $feedString;
	}

	/**
	 * @param StringInput $tempPath
	 * @return \Feedr\Beans\TempFile
	 */
	public function createTempResource($tempPath)
	{
		// TODO: Implement createTempFile() method.
	}

}
