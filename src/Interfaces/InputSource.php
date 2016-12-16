<?php

namespace Feedr\Interfaces;

use Feedr\Beans\TempFile;

interface InputSource
{

	/**
	 * @param string $tempPath
	 * @return TempFile
	 */
	public function createTempFile($tempPath);

}
