<?php

namespace Feedr\Interfaces;

use Feedr\Entities\TempFile;

interface InputSource
{

	/**
	 * @param string $tempPath
	 * @return TempFile
	 */
	public function createTempFile($tempPath);

}
