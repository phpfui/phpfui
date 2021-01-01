<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Number input fields
 */
class Number extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Number input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('number', $name, $label, $value);
		}
	}
