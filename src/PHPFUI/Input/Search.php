<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Search input fields
 */
class Search extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Search input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('search', $name, $label, $value);
		}
	}
