<?php

namespace Feedr\Interfaces;

/**
 * Interface TempResource
 * @package Feedr\Interfaces
 */
interface TempResource
{

	/**
	 * @return string
	 */
	function getResourceUri();

	/**
	 * @param $input
	 */
	function write($input);

}
