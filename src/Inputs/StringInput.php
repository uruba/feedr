<?php

namespace Feedr\Inputs;

use Feedr\Interfaces\InputSource;

class StringInput implements InputSource
{

	/** @var StringInput */
	private $feedString;

	public function __construct($feedString)
	{
		$this->feedString = $feedString;
	}

	/**
	 * @param StringInput $tempPath
	 * @return \Feedr\Beans\TempFile
	 */
	public function createTempFile($tempPath)
	{
		// TODO: Implement createTempFile() method.
	}

}
