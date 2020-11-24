<?php

namespace PHPFUI\Input;

/**
 * Show a check box as a switch
 */
class SwitchCheckBox extends \PHPFUI\Input\SwitchRadio
	{
	public function __construct(string $name, $value = 0, string $title = '')
		{
		parent::__construct($name, 1, $title, 'checkbox');
		$this->add("<input type='hidden' name='{$name}' value='0'>");
		$this->setChecked(! empty($value));
		$this->input->setAttribute('value', 1);
		}
	}
