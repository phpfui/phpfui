<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for DateTime input fields
 */
class DateTime extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a DateTime input
	 *
	 * @param \PHPFUI\Interfaces\Page $page for needed JS (unused, reserved for
	 *  			future use)
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	// @phpstan-ignore-next-line
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('datetime-local', $name, $label, $value);
		}
	}
