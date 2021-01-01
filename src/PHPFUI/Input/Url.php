<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Url input fields
 */
class Url extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Url input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('url', $name, $label, $value);
		}
	}
