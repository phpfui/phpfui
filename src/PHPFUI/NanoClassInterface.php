<?php

namespace PHPFUI;

/**
 * Objects returned by NanoController must implement this interface.
 */
interface NanoClassInterface
	{
	public function __construct(NanoController $controller);
	}
