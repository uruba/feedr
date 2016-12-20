<?php

namespace Feedr;

use Feedr\Core\Reader;
use Feedr\Interfaces\InputSource;
use Feedr\Interfaces\Specs\Spec;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Feedr
 * @package Feedr
 */
class Feedr
{

	/** @var string */
	private $tempPath;

	/** @var Reader */
	private $reader;

	/** @var Spec */
	private $spec;

	/** @var LoggerInterface */
	private $logger;

	/**
	 * Feedr constructor.
	 * @param string $tempPath
	 * @param Spec $mode
	 */
	public function __construct($tempPath, Spec $mode)
	{
		$this->tempPath = $tempPath;
		$this->spec = $mode;

		$this->logger = new NullLogger();

		$this->reader = new Reader($this->spec);
	}

	/**
	 * @param InputSource $inputSource
	 * @return Feedr\Beans\Feed
	 */
	public function readFeed(InputSource $inputSource)
	{
		return $this->reader->read($inputSource, $this->tempPath);
	}

	/**
	 * @param InputSource $inputSource
	 * @param \DateTime $dateTime
	 */
	public function readFeedConstraintFrom(InputSource $inputSource, \DateTime $dateTime)
	{

	}

	/**
	 * @return LoggerInterface
	 */
	public function getLogger()
	{
		return $this->logger;
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
	 * @param LoggerInterface $logger
	 */
	public function setLogger($logger)
	{
		$this->logger = $logger;
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
