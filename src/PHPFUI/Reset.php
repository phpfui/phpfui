<?php

namespace PHPFUI;

/**
 * Simple wrapper for Reset input fields
 */
class Reset extends \PHPFUI\Button
	{
	/**
	 * @param string $name of the field
	 */
	public function __construct(string $name = 'Reset')
		{
		parent::__construct('');
		$this->setAttribute('type', 'reset');
		$this->setAttribute('value', $name);
		$this->setElement('input');
		}
	}
