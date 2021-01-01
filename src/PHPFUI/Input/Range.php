<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Range input fields
 */
class Range extends \PHPFUI\Input\Input
	{
  /**
   * Construct a Range input
   *
   * @param string $name of the field
   * @param string $label defaults to empty
   * @param ?string $value defaults to empty
   */
	public function __construct(string $name, string $label = '', ?string $value = '0.0')
		{
		parent::__construct('range', $name, $label, $value);
		}
	}
