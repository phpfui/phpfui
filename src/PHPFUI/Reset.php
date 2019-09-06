<?php

namespace PHPFUI;

/**
 * Simple wrapper for Reset input fields
 */
class Reset extends Button
	{

	/**
	 * Construct a Reset input
	 *
	 * @param string $name of the field
	 * @param string $value defaults to empty
	 */
	public function __construct(string $name = 'Reset', string $value = 'Reset')
		{
		parent::__construct($name);
		$this->setAttribute('type', 'reset');
		$this->setAttribute('value', $value);
		}

	}
