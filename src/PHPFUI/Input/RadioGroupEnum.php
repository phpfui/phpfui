<?php

namespace PHPFUI\Input;

class RadioGroupEnum extends \PHPFUI\Input\RadioGroup implements \Countable
	{
	/**
	 * Construct a Radio Button Enum Group
	 *
	 * @param string $name of the button
	 * @param string $label optional
	 * @param $enum initial value from the supplied enum
	 */
	public function __construct(string $name, string $label, $enum)
		{
		parent::__construct($name, $label, $enum->value);

		foreach ($enum::cases() as $properties)
			{
			$parts = \explode('_', $properties->name);
			$this->addButton(\ucwords(\strtolower(\implode(' ', $parts))), $properties->value);
			}
		}
	}
