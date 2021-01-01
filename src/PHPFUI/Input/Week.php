<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Week input fields
 */
class Week extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Week input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('week', $name, $label, $value);
		}
	}
