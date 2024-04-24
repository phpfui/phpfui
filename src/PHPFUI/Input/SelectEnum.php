<?php

namespace PHPFUI\Input;

/**
 * A wrapper for Select control from an enum
 */
class SelectEnum extends \PHPFUI\Input\Select
	{
	/**
	 * @param string $name of the button
	 * @param string $label optional
	 * @param $enum initial value from the supplied enum
	 */
	public function __construct(string $name, string $label, $enum)	// @phpstan-ignore-line
		{
		parent::__construct($name, $label);

		foreach ($enum::cases() as $property)
			{
			$optionLabel = \ucwords(\strtolower(\str_replace('_', ' ', $property->name)));
			$this->addOption($optionLabel, $property->value, $property->value == $enum->value);
			}
		}
	}
