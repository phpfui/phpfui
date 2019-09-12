<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Color input fields
 */
class Color extends Input
	{

	/**
	 * Construct a Color input
	 *
	 * @param string $name of the field
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, ?string $value = '')
		{
		parent::__construct('color', $name, $value);
		}

	}
