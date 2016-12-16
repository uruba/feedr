<?php

namespace Feedr\Core;

use Feedr\Entities\TempFile;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Specs\Spec;

class Reader
{

	/** @var \XMLReader */
	private $xmlReader;

	public function __construct()
	{
		$this->xmlReader = new \XMLReader();
	}

	public function read(Spec $mode, InputSource $inputSource, $tempPath, $deleteTempFile = TRUE)
	{
		/** @var TempFile $tempFile */
		$tempFile = $inputSource->createTempFile($tempPath);

		$this->xmlReader->open($tempFile->getFilePath());

		foreach (explode('/', $mode->getSpecDocument()->getRoot()) as $pathPart) {
			while ($this->xmlReader->read()) {
				if ($this->xmlReader->nodeType == \XMLReader::ELEMENT) {
					break;
				}
			}

			if ($this->xmlReader->name != $pathPart) {
				throw new \Feedr\Exceptions\InvalidFeedException(
					sprintf(
						"The root path must be '%s'",
						$mode->getSpecDocument()->getRoot()
					)
				);
			}
		}

		$this->xmlReader->close();

		if ($deleteTempFile) {
			$tempFile->delete();
		}
	}

}
