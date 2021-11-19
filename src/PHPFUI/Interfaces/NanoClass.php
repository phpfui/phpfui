<?php

namespace PHPFUI\Interfaces;

/**
 * Objects returned by NanoController must implement this interface.
 */
interface NanoClass
	{
	public function __construct(\PHPFUI\Interfaces\NanoController $controller);
	}
