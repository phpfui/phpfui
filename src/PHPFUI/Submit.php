<?php

namespace PHPFUI;

/**
 * Submit buttons are actual buttons.  Due to the implementation of Foundation 6.6
 * they can not be input fields, but will function like a traditional input type.
 */
class Submit extends Button
	{

	/**
	 * @param string $text of button, defaults to 'Save'
	 * @param string $name of field to be submitted, will be 'submit' unless provided
	 */
	public function __construct(string $text = 'Save', string $name = 'submit')
		{
		parent::__construct($text);
		$this->setAttribute('type', 'submit');
		$this->addClass('radius');
		$this->addAttribute('value', $text);
		$this->addAttribute('name', $name);
		$this->addAttribute('onkeypress', 'return event.keyCode!=13;');
		}
	}
