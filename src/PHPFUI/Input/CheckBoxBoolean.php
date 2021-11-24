<?php

namespace PHPFUI\Input;

/**
 * Simple CheckBox wrapper
 */
class CheckBoxBoolean extends \PHPFUI\Input\CheckBox
	{
	/**
	 * Construct a CheckBoxBoolean
	 *
	 * Field will always have a value when posted.
	 *
	 * @param string $name of the checkbox
	 * @param string $label for the checkbox, will have automatic
	 *               for='id' logic applied
	 * @param ?bool $value initial value, default 0
	 */
	public function __construct(string $name, string $label = '', ?bool $value = false)
		{
		$this->add(new \PHPFUI\Input\Hidden($name, 0));
		parent::__construct($name, $label, 1);
		$this->setChecked($value);
		}
	}
