<?php

namespace Feedr\Interfaces;

use Feedr\Beans\TempFile;

/**
 * Interface InputSource
 * @package Feedr\Interfaces
 */
interface InputSource
{

	/**
	 * @param string $tempPath
	 * @return TempFile
	 */
	public function createTempFile($tempPath);

}
