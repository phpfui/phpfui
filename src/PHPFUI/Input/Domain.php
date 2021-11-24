<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Domain input fields
 */
class Domain extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Domain validated input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('text', $name, $label, $value);
		$this->addAttribute('pattern', 'domain');
		}
	}
