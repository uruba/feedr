<?php

namespace Feedr;

use Feedr\Core\Reader;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Specs\Spec;

class Feedr
{

	/** @var string */
	private $tempPath;

	/** @var Reader */
	private $reader;

	/** @var Spec */
	private $spec;

	public function __construct($tempPath, Spec $mode)
	{
		$this->tempPath = $tempPath;
		$this->spec = $mode;

		$this->reader = new Reader();
	}

	public function readFeed(InputSource $inputSource)
	{
		$this->reader->read($this->spec, $inputSource, $this->tempPath);
	}

	public function readFeedConstraintFrom(InputSource $inputSource, \DateTime $dateTime)
	{

	}

	/**
	 * @return Spec
	 */
	public function getMode()
	{
		return $this->spec;
	}

	/**
	 * @return string
	 */
	public function getTempPath()
	{
		return $this->tempPath;
	}

	/**
	 * @param Spec $mode
	 */
	public function setMode(Spec $mode)
	{
		$this->spec = $mode;
	}

	/**
	 * @param string $tempPath
	 */
	public function setTempPath($tempPath)
	{
		$this->tempPath = $tempPath;
	}

}
