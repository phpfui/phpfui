<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Text input fields
 */
class Text extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Text input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('text', $name, $label, (string)$value);
		}
	}
