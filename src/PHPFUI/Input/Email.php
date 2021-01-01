<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Email input fields
 */
class Email extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Email input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('email', $name, $label, $value);
		}
	}
