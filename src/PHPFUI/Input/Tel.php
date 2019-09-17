<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Tel input fields
 */
class Tel extends Input
	{

	/**
	 * Construct a Tel input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('tel', $name, $label, $value);
		}
	}
