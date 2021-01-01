<?php

namespace PHPFUI;

/**
 * Simple wrapper for FieldSets
 */
class FieldSet extends \PHPFUI\HTML5Element
	{
	/**
	 * Make a field set
	 *
	 * @param string $legend for the field set
	 */
	public function __construct(string $legend = '')
		{
		parent::__construct('fieldset');
		$this->addClass('fieldset');

		if ($legend)
			{
			$this->add("<legend>{$legend}</legend>");
			}
		}
	}
