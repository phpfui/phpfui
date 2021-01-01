<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Password input fields
 */
class Password extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Password input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('password', $name, $label, $value);
		}
	}
