<?php

namespace PHPFUI\Input;

class SwitchCheckBox extends SwitchRadio
	{
	public function __construct(string $name, $value = 0, string $title = '')
		{
		parent::__construct($name, 1, $title, 'checkbox');
		$this->add("<input type='hidden' name='{$name}' value='0'>");
		$this->setChecked(! empty($value));
		$this->input->setAttribute('value', 1);
		}
	}
